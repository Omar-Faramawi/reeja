<?php namespace Tamkeen\Ajeer\Services\Nitaqat;

use Illuminate\Database\Connection;
use Illuminate\Database\DatabaseManager;

class IntegrationFileGenerator
{
    /**
     * @var Connection
     */
    protected $db;

    /**
     * @param DatabaseManager $db
     */
    public function __construct(DatabaseManager $db)
    {
        $this->db = $db->connection();
    }

    public function generateCsvFile(array $counts)
    {
        $csv = '';

        foreach ($counts as $laborOfficeId => $establishments) {
            foreach ($establishments as $sequenceNumber => $count) {
                $csv .= "$laborOfficeId,$sequenceNumber,$count\n";
            }
        }

        return $csv;
    }

    /**
     * @return string
     */
    public function getEstablishmentsNoticeCount()
    {
        $establishmentNotices = [];

        // Visitor_notices
        $this->db->table('benefs')->select(
            'establishments.labor_office_id as laborOfficeId',
            'establishments.sequence_number as sequenceNumber',
            $this->db->raw('COUNT(`benefs`.`benef_id`) as laborerCount')
        )
            ->join('visitor_notices', 'benefs.notice_id', '=', 'visitor_notices.id')
            ->join('establishments', 'benefs.benef_id', '=', 'establishments.id')
            ->where('visitor_notices.status', '=', 1)
            ->where('benefs.benef_type', $this->db->raw("'Tamkeen\\\\Ajeer\\\\Models\\\\Establishment'"))
            ->where('visitor_notices.expiry_date', '>=', date('y-m-d'))
            ->groupBy('benefs.benef_id')
            ->chunk(100, function ($rows) use (&$establishmentNotices) {
                foreach ($rows as $row) {
                    array_set($establishmentNotices, $row->laborOfficeId . '.' . $row->sequenceNumber, $row->laborerCount);
                }
            });
        //Companion_notices
        $this->db->table('companion_notices')->select(
            'establishments.labor_office_id as laborOfficeId',
            'establishments.sequence_number as sequenceNumber',
            $this->db->raw('COUNT(companion_notices.laborer_id_number) as laborerCount')
        )
            ->join('establishments', 'establishments.id', '=', 'companion_notices.benef_id')
            ->where('companion_notices.status', '=', 3)
            ->where('companion_notices.expiry_date', '>=', date('y-m-d'))
            ->groupBy('companion_notices.benef_id')
            ->chunk(100, function ($rows) use (&$establishmentNotices) {
                foreach ($rows as $row) {
                    array_set($establishmentNotices, $row->laborOfficeId . '.' . $row->sequenceNumber, $row->laborerCount);
                }
            });

        return $establishmentNotices;
    }
}
