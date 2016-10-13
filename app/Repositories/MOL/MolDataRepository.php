<?php namespace Tamkeen\Ajeer\Repositories\MOL;

use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Support\Collection;

interface MolDataRepository
{
    const NITAQAT_TINY_RED_ID   = 1;
    const NITAQAT_TINY_GREEN_ID = 3;

    const NITAQAT_RED_PREFIX      = 100;
    const NITAQAT_YELLOW_PREFIX   = 200;
    const NITAQAT_LOW_GREEN_ID    = 300;
    const NITAQAT_MED_GREEN_ID    = 310;
    const NITAQAT_HIGH_GREEN_ID   = 320;
    const NITAQAT_PLATINUM_PREFIX = 400;

    const SIZE_TINY   = 1;
    const SIZE_SMALL  = 2;
    const SIZE_MEDIUM = 3;
    const SIZE_LARGE  = 4;
    const SIZE_HUGE   = 5;

    /**
     * Get the user ID number from MOL.
     *
     * @param int $userId
     *
     * @return int
     */
    public function getUserIdNumber($userId);

    /**
     * @param int $establishmentId
     *
     * @return array
     *
     * @throws ModelNotFoundException
     */
    public function findEstablishmentById($establishmentId);

    /**
     * @param int $laborOfficeId
     * @param int $sequenceNumber
     *
     * @return array
     *
     * @throws ModelNotFoundException
     */
    public function findEstablishmentByNumber($laborOfficeId, $sequenceNumber);

    /**
     * @param int $owner
     * @param int $laborOfficeId
     * @param int $sequenceNumber
     *
     * @return object
     *
     * @throws ModelNotFoundException
     */
    public function findEstablishmentByOwner($owner, $laborOfficeId, $sequenceNumber);

    /**
     * @param $idNumber
     *
     * @return object
     *
     * @throws ModelNotFoundException
     */
    public function findEstablishmentsByUserIdNumber($idNumber);

    /**
     * @param int $establishmentId
     *
     * @return Collection
     */
    public function fetchEstablishmentUsers($establishmentId);

    /**
     * @param int $establishmentId
     *
     * @return Collection
     */
    public function fetchEstablishmentLaborers($establishmentId);
    
    /**
     * @param int $establishmentId
     *
     * @return int
     */
    public function fetchEstablishmentLaborersCount($establishmentId);
    
    /**
     * Get the laborer data.
     *
     * @param int $idNumber
     * @param int $establishmentId
     *
     * @return array
     */
    public function findLaborer($idNumber, $establishmentId = null);

    /**
     * Get the ajeer laborer data.
     *
     * @param int $idNumber
     * @param int $establishmentId
     *
     * @return array
     */
    public function findAjeerLaborer($idNumber, $establishmentId = null);

    /**
     * Get the current economic activities list.
     *
     * @return Collection
     */
    public function fetchActivities();

    /**
     * Get the jobs list.
     *
     * @param bool $withoutSaudisOnlyJobs
     *
     * @return integer
     */
    public function fetchJobsLookup($withoutSaudisOnlyJobs);

    /**
     * Get the nationalities list.
     *
     * @return Collection   
     */
    public function fetchNationalitiesLookup();

    /**
     * fetch owner ID for establishment
     *
     * @param $establishment_id
     * 
     * @return Collection
     */
    public function getOwnerByEstablishmentId($establishment_id);

}
