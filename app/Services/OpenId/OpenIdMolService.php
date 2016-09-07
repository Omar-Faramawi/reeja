<?php namespace Tamkeen\Ajeer\Services\OpenId;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\RequestException;
use Illuminate\Http\Request;
use RuntimeException;
use SimpleXMLElement;
use Tamkeen\Ajeer\Repositories\MOL\MolDataRepository;

class OpenIdMolService implements OpenIdService
{
    const NAMESPACE_2_0 = 'http://specs.openid.net/auth/2.0';
    const SELECT_IDENTITY = 'http://specs.openid.net/auth/2.0/identifier_select';

    /**
     * @var MolDataRepository
     */
    private $molDataRepository;

    /**
     * @var string
     */
    private $providerEndpoint;

    /**
     * @var string
     */
    private $returnToUrl;

    /**
     * @param MolDataRepository $molDataRepository
     * @param string            $providerEndpoint
     * @param string            $returnToUrl
     */
    public function __construct(MolDataRepository $molDataRepository, $providerEndpoint, $returnToUrl)
    {
        $this->molDataRepository = $molDataRepository;
        $this->providerEndpoint  = $providerEndpoint;
        $this->returnToUrl       = $returnToUrl;
    }

    /**
     * @param Request $request
     *
     * @return array
     *
     * @throws OpenIdAuthenticationFailedException
     */
    public function authenticate(Request $request)
    {
        $params = $this->getParams($request);

        $xml = $this->fetchUserXml($params);

        try {
            $userData = $this->parseXml($xml);

        } catch (RuntimeException $e) {
            throw new OpenIdAuthenticationFailedException('', 0, $e);
        }

        return $userData;
    }

    /**
     * @param Request $request
     *
     * @return array
     */
    private function getParams(Request $request)
    {
        $params = [];

        foreach ($request->all() as $key => $value) {
            if (strpos($key, 'openid_') === 0) {
                $params['openid.' . substr($key, 7)] = $value;
            }
        }

        return $params;
    }

    /**
     * @param array $params
     *
     * @return SimpleXMLElement
     *
     * @throws OpenIdAuthenticationFailedException
     */
    private function fetchUserXml(array $params)
    {
        $params['openid.mode'] = 'check_authentication';

        $client = new Client();
        $userDataUrl = $this->createProviderUrl($params);

        try {
            $response = $client->get($userDataUrl, ['timeout' => 30]);

        } catch (RequestException $e) {
            throw new OpenIdAuthenticationFailedException('', 0, $e);
        }

        if ($response->getHeader('content-length') == 0 || !$response->hasHeader('content-type')) {
            throw new OpenIdAuthenticationFailedException('Empty response.');
        }

        return $response->xml();
    }

    /**
     * @param SimpleXMLElement $xml
     *
     * @return array
     */
    private function parseXml(SimpleXMLElement $xml)
    {
        $userId  = (string) $xml->contactDetails['exID'];

        $userData = [
            'id_number' => $this->molDataRepository->getUserIdNumber($userId),
            'name'      => sprintf('%s %s', $xml->contactDetails->fname, $xml->contactDetails->lname),
            'mobile'    => sprintf('%s', $xml->contactDetails->phone),
            'email'     => sprintf('%s', $xml->contactDetails->email),
        ];

        $establishments = [];

        foreach ($xml->companies[0] as $e) {
            array_set($establishments, sprintf('%s-%s', $e->city, $e['exID']), sprintf('%s', $e->name));
        }

        $userData['establishments'] = $establishments;

        return $userData;
    }

    /**
     * @return string
     */
    public function getAuthenticationEndpoint()
    {
        return $this->createProviderUrl([
            'openid.ns'         => static::NAMESPACE_2_0,
            'openid.mode'       => 'checkid_setup',
            'openid.return_to'  => $this->returnToUrl,
            'openid.claimed_id' => static::SELECT_IDENTITY,
            'openid.identity'   => static::SELECT_IDENTITY,
        ]);
    }

    /**
     * @param array $params
     *
     * @return string
     */
    private function createProviderUrl(array $params)
    {
        return $this->providerEndpoint . '?' . http_build_query($params);
    }
}
