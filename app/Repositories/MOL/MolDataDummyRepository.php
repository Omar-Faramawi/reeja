<?php namespace Tamkeen\Ajeer\Repositories\MOL;

use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Support\Collection;

class MolDataDummyRepository implements MolDataRepository
{
    /**
     * Get the user ID number from MOL.
     *
     * @param int $userId
     *
     * @return int
     *
     * @throws ModelNotFoundException
     */
    public function getUserIdNumber($userId)
    {
        $userIdNumber = array_get($this->users(), $userId);
        
        if ($userIdNumber) {
            return $userIdNumber;
        }
        
        throw new ModelNotFoundException;
    }
    
    /**
     * @param int $establishmentId
     *
     * @return array
     *
     * @throws ModelNotFoundException
     */
    public function findEstablishmentById($establishmentId)
    {
        $establishment = array_first($this->establishments(), function ($_, $establishment) use ($establishmentId) {
            return data_get($establishment, 'FK_establishment_id') == $establishmentId;
        });
        
        if ($establishment) {
            return (object)$establishment;
        }
        
        throw new ModelNotFoundException;
    }
    
    /**
     * @param int $laborOfficeId
     * @param int $sequenceNumber
     *
     * @return array
     *
     * @throws ModelNotFoundException
     */
    public function findEstablishmentByNumber($laborOfficeId, $sequenceNumber)
    {
        $establishment = array_first($this->establishments(), function ($k, $v) use ($laborOfficeId, $sequenceNumber) {
            return $v['labor_office_id'] == $laborOfficeId && $v['sequence_number'] == $sequenceNumber;
        });
        
        if ($establishment) {
            return (object)$establishment;
        }
        
        throw new ModelNotFoundException;
    }
    
    /**
     * @param int $owner
     * @param int $laborOfficeId
     * @param int $sequenceNumber
     *
     * @return array
     *
     * @throws ModelNotFoundException
     */
    public function findEstablishmentByOwner($owner, $laborOfficeId, $sequenceNumber)
    {
        $establishment = $this->findEstablishmentByNumber($laborOfficeId, $sequenceNumber);
        
        if (data_get($establishment, 'owner') == $owner) {
            return $establishment;
        }
        
        throw new ModelNotFoundException;
    }
    
    /**
     * @param $idNumber
     *
     * @return object
     *
     * @throws ModelNotFoundException
     */
    public function findEstablishmentsByUserIdNumber($idNumber)
    {
        // TODO: Implement getEstablishmentsByUserIdNumber() method.
    }
    
    /**
     * Get the laborer date.
     *
     * @param int $idNumber
     * @param int $establishmentId
     *
     * @return array
     */
    public function findLaborer($idNumber, $establishmentId = null)
    {
        $laborer = $this->laborers()->whereLoose('id_number', $idNumber)->first();
        
        if ($laborer && !$establishmentId) {
            return $laborer;
        }
        
        if ($laborer && data_get($laborer, 'FK_establishment_id') == $establishmentId) {
            return $laborer;
        }
        
        throw new ModelNotFoundException;
    }
    
    public function findAjeerLaborer($idNumber, $establishmentId = null)
    {
        return $this->findLaborer($idNumber, $establishmentId);
    }
    
    /**
     * @param $establishmentId
     *
     * @return Collection
     */
    public function fetchEstablishmentUsers($establishmentId)
    {
        return collect([
            [
                'name'      => 'ibrahim',
                'id_number' => 1068212040,
                'email'     => 'i.ashshohail@tamkeen.it',
            ],
        ]);
    }
    
    /**
     * @param $establishmentId
     *
     * @return Collection
     */
    public function fetchEstablishmentLaborers($establishmentId)
    {
        $establishmentLaborers = array_where($this->laborers(), function ($key, $laborer) use ($establishmentId) {
            return data_get($laborer, 'FK_establishment_id') == $establishmentId;
        });

        return collect($establishmentLaborers);
    }

    /**
     * @param $establishmentId
     *
     * @return int
     */
    public function fetchEstablishmentLaborersCount($establishmentId)
    {
        $establishmentLaborers = array_where($this->laborers(), function ($key, $laborer) use ($establishmentId) {
            return data_get($laborer, 'FK_establishment_id') == $establishmentId;
        });

        return collect($establishmentLaborers)->count();
    }
    
    /**
     * Get the current economic activities list.
     *
     * @return array
     */
    public function fetchActivities()
    {
        return [
            1 => 'البناء والتشييد',
            2 => 'السباكة والحدادة',
            3 => 'البيع والشراء',
            4 => 'الصيدلة',
            5 => 'الصيد',
        ];
    }
    
    /**
     * Get the jobs list.
     *
     * @param bool $withoutSaudisOnlyJobs
     *
     * @return Collection
     */
    public function fetchJobsLookup($withoutSaudisOnlyJobs)
    {
        return collect($this->jobs())->keyBy('id');
    }
    
    /**
     * @param $establishment_id
     *
     * @return mixed
     */
    public function getLaborersByEstablishmentId($establishment_id)
    {
        return array_filter($this->laborers(), function ($laborer) use ($establishment_id) {
            return $laborer['FK_establishment_id'] == $establishment_id;
        });
    }
    
    /**
     * fetch owner ID for establishment
     *
     * @param $establishment_id
     *
     * @return integer
     */
    public function getOwnerByEstablishmentId($establishment_id)
    {
        return 10000000000;
    }
    
    
    /**
     * @return Collection
     */
    private function establishments()
    {
        return collect([
            [
                'FK_establishment_id'          => 1,
                'labor_office_id'              => 1,
                'sequence_number'              => 1,
                'name'                         => 'منشأة تجريبية #1',
                'FK_economic_activity_id'      => 10,
                'economic_activity'            => 'السياحة',
                'FK_main_economic_activity_id' => 60,
                'FK_sub_economic_activity_id'  => 6268,
                'status_id'                    => 1,
                'status'                       => 'قائمة',
                'cr_number'                    => 100,
                'cr_end_date'                  => '01-01-2018',
                'statement_number'             => '13215-25',
                'statement_end_date'           => '01-01-2016',
                'wasel_status'                 => 1,
                'wasel_end_date'               => '01-01-2018',
                'wasel_expiry_date'            => '01-01-2018',
                'nitaqat_color_id'             => self::NITAQAT_PLATINUM_PREFIX,
                'nitaqat_color'                => 'بلاتينيوم',
                'size_id'                      => self::SIZE_SMALL,
                'unused_visas'                 => 1,
                'owner'                        => '1068212040',
                'district'                     => 'غرناطة',
                'region'                       => 'النسيم الغربي',
                'city'                         => 'الرياض',
                'street'                       => '1',
                'phone'                        => '2393282',
            ],
            [
                'FK_establishment_id'          => 2,
                'labor_office_id'              => 1,
                'sequence_number'              => 2,
                'name'                         => 'منشأة تجريبية #2',
                'FK_economic_activity_id'      => 10,
                'economic_activity'            => 'الصيدليات',
                'FK_main_economic_activity_id' => 30,
                'FK_sub_economic_activity_id'  => 3697,
                'status_id'                    => 1,
                'status'                       => 'قائمة',
                'cr_number'                    => 200,
                'cr_end_date'                  => '10-10-2015',
                'statement_number'             => '13215-25',
                'statement_end_date'           => '10-10-2015',
                'wasel_status'                 => 1,
                'wasel_end_date'               => '01-01-2018',
                'wasel_expiry_date'            => '01-01-2018',
                'nitaqat_color_id'             => self::NITAQAT_RED_PREFIX,
                'nitaqat_color'                => 'احمر منخفض',
                'size_id'                      => self::SIZE_SMALL,
                'unused_visas'                 => 1,
                'owner'                        => '1068212040',
                'district'                     => 'غرناطة',
                'region'                       => 'النسيم الغربي',
                'city'                         => 'الرياض',
                'street'                       => '1',
                'phone'                        => '2393282',
            ],
            [
                'FK_establishment_id'          => 3,
                'labor_office_id'              => 1,
                'sequence_number'              => 3,
                'name'                         => 'منشأة تجريبية #3',
                'FK_economic_activity_id'      => 14,
                'economic_activity'            => 'الصيدليات',
                'FK_main_economic_activity_id' => 30,
                'FK_sub_economic_activity_id'  => 3694,
                'status_id'                    => 1,
                'status'                       => 'قائمة',
                'cr_number'                    => 200,
                'cr_end_date'                  => '01-01-2016',
                'statement_number'             => '13215-25',
                'statement_end_date'           => '01-01-2016',
                'wasel_status'                 => 0,
                'wasel_end_date'               => '01-01-2016',
                'wasel_expiry_date'            => '01-01-2016',
                'nitaqat_color_id'             => self::NITAQAT_LOW_GREEN_ID,
                'nitaqat_color'                => 'أخضر منخفض',
                'size_id'                      => self::SIZE_SMALL,
                'unused_visas'                 => 1,
                'owner'                        => '1068212040',
                'district'                     => 'غرناطة',
                'region'                       => 'النسيم الغربي',
                'city'                         => 'الرياض',
                'street'                       => '1',
                'phone'                        => '2393282',
            ],
            [
                'FK_establishment_id'          => 4,
                'labor_office_id'              => 1,
                'sequence_number'              => 4,
                'name'                         => 'منشأة تجريبية #4',
                'FK_economic_activity_id'      => 37,
                'economic_activity'            => 'المدارس',
                'FK_main_economic_activity_id' => 10,
                'FK_sub_economic_activity_id'  => 1408,
                'status_id'                    => 1,
                'status'                       => 'قائمة',
                'note'                         => '',
                'cr_number'                    => 203252352350,
                'cr_end_date'                  => '01-01-2018',
                'statement_number'             => '13215-25',
                'statement_end_date'           => '01-01-2017',
                'wasel_status'                 => 1,
                'wasel_end_date'               => '01-01-2018',
                'wasel_expiry_date'            => '01-01-2018',
                'nitaqat_color_id'             => self::NITAQAT_YELLOW_PREFIX,
                'nitaqat_color'                => 'أصفر',
                'size_id'                      => self::SIZE_MEDIUM,
                'low_green_quota'              => 10,
                'owner'                        => '1068212040',
                'district'                     => 'غرناطة',
                'region'                       => 'النسيم الغربي',
                'city'                         => 'الرياض',
                'street'                       => '1',
                'phone'                        => '2393282',
            ],
            [
                'FK_establishment_id'          => 5,
                'labor_office_id'              => 1,
                'sequence_number'              => 5,
                'name'                         => 'منشأة تجريبية #5',
                'FK_economic_activity_id'      => 37,
                'economic_activity'            => 'المدارس',
                'FK_main_economic_activity_id' => 10,
                'FK_sub_economic_activity_id'  => 1408,
                'status_id'                    => 2,
                'status'                       => 'غير قائمة',
                'note'                         => 'لديها ملاحظات بإيقاف الخدمات عنها',
                'cr_number'                    => 203252352350,
                'cr_end_date'                  => '01-01-2018',
                'statement_number'             => '13215-25',
                'statement_end_date'           => '01-01-2017',
                'wasel_status'                 => 1,
                'wasel_end_date'               => '01-01-2018',
                'wasel_expiry_date'            => '01-01-2018',
                'nitaqat_color_id'             => self::NITAQAT_YELLOW_PREFIX,
                'nitaqat_color'                => 'أصفر',
                'size_id'                      => self::SIZE_MEDIUM,
                'low_green_quota'              => 10,
                'owner'                        => '1068212040',
                'district'                     => 'غرناطة',
                'region'                       => 'النسيم الغربي',
                'city'                         => 'الرياض',
                'street'                       => '1',
                'phone'                        => '2393282',
            ],
            [
                'FK_establishment_id'          => 6,
                'labor_office_id'              => 1,
                'sequence_number'              => 6,
                'name'                         => 'منشأة تجريبية #6',
                'FK_economic_activity_id'      => 37,
                'economic_activity'            => 'المدارس',
                'FK_main_economic_activity_id' => 10,
                'FK_sub_economic_activity_id'  => 1408,
                'status_id'                    => 2,
                'status'                       => 'غير قائمة',
                'note'                         => 'لديها مشاكل متعلقة بنظام حماية الأجور',
                'cr_number'                    => 203252352350,
                'cr_end_date'                  => '01-01-2018',
                'statement_number'             => '13215-25',
                'statement_end_date'           => '01-01-2017',
                'wasel_status'                 => 1,
                'wasel_end_date'               => '01-01-2018',
                'wasel_expiry_date'            => '01-01-2018',
                'nitaqat_color_id'             => self::NITAQAT_YELLOW_PREFIX,
                'nitaqat_color'                => 'أصفر',
                'size_id'                      => self::SIZE_MEDIUM,
                'low_green_quota'              => 10,
                'owner'                        => '1068212040',
                'district'                     => 'غرناطة',
                'region'                       => 'النسيم الغربي',
                'city'                         => 'الرياض',
                'street'                       => '1',
                'phone'                        => '2393282',
            ],
            [
                'FK_establishment_id'          => 7,
                'labor_office_id'              => 1,
                'sequence_number'              => 7,
                'name'                         => 'منشأة تجريبية #7',
                'FK_economic_activity_id'      => 37,
                'economic_activity'            => 'المدارس',
                'FK_main_economic_activity_id' => 10,
                'FK_sub_economic_activity_id'  => 1408,
                'status_id'                    => 2,
                'status'                       => 'غير قائمة',
                'note'                         => 'لديها مشاكل متعلقة بنظام حماية الأجور',
                'cr_number'                    => 203252352350,
                'cr_end_date'                  => '01-01-2018',
                'statement_number'             => '13215-25',
                'statement_end_date'           => '01-01-2017',
                'wasel_status'                 => 1,
                'wasel_end_date'               => '01-01-2018',
                'wasel_expiry_date'            => '01-01-2018',
                'nitaqat_color_id'             => self::NITAQAT_YELLOW_PREFIX,
                'nitaqat_color'                => 'أصفر',
                'size_id'                      => self::SIZE_MEDIUM,
                'low_green_quota'              => 10,
                'owner'                        => '1068212040',
                'district'                     => 'غرناطة',
                'region'                       => 'النسيم الغربي',
                'city'                         => 'الرياض',
                'street'                       => '1',
                'phone'                        => '2393282',
            ],
            [
                'FK_establishment_id'          => 8,
                'labor_office_id'              => 1,
                'sequence_number'              => 8,
                'name'                         => 'منشأة تجريبية #8',
                'FK_economic_activity_id'      => 37,
                'economic_activity'            => 'المدارس',
                'FK_main_economic_activity_id' => 10,
                'FK_sub_economic_activity_id'  => 1408,
                'status_id'                    => 1,
                'status'                       => 'قائمة',
                'note'                         => '',
                'cr_number'                    => 203252352350,
                'cr_end_date'                  => '01-01-2018',
                'statement_number'             => '13215-25',
                'statement_end_date'           => '01-01-2017',
                'wasel_status'                 => 1,
                'wasel_end_date'               => '01-01-2014',
                'wasel_expiry_date'            => '01-01-2014',
                'nitaqat_color_id'             => self::NITAQAT_YELLOW_PREFIX,
                'nitaqat_color'                => 'أصفر',
                'size_id'                      => self::SIZE_MEDIUM,
                'low_green_quota'              => 10,
                'owner'                        => '1068212040',
                'district'                     => 'غرناطة',
                'region'                       => 'النسيم الغربي',
                'city'                         => 'الرياض',
                'street'                       => '1',
                'phone'                        => '2393282',
            ],
            [
                'FK_establishment_id'          => 9,
                'labor_office_id'              => 1,
                'sequence_number'              => 9,
                'name'                         => 'منشأة تجريبية #9',
                'FK_economic_activity_id'      => 37,
                'economic_activity'            => 'المدارس',
                'FK_main_economic_activity_id' => 10,
                'FK_sub_economic_activity_id'  => 1408,
                'status_id'                    => 2,
                'status'                       => 'غير قائمة',
                'note'                         => 'غير مسجلة في خدمة العنوان الوطني لدى مؤسسة البريد السعودي',
                'cr_number'                    => 203252352350,
                'cr_end_date'                  => '01-01-2018',
                'statement_number'             => '13215-25',
                'statement_end_date'           => '01-01-2017',
                'wasel_status'                 => 1,
                'wasel_end_date'               => '01-01-2018',
                'wasel_expiry_date'            => '01-01-2018',
                'nitaqat_color_id'             => self::NITAQAT_YELLOW_PREFIX,
                'nitaqat_color'                => 'أصفر',
                'size_id'                      => self::SIZE_MEDIUM,
                'low_green_quota'              => 10,
                'owner'                        => '1068212040',
                'district'                     => 'غرناطة',
                'region'                       => 'النسيم الغربي',
                'city'                         => 'الرياض',
                'street'                       => '1',
                'phone'                        => '2393282',
            ],
        ]);
    }
    
    /**
     * @return Collection
     */
    private function laborers()
    {
        return collect([
            [
                'id_number'           => '2222222222',
                'id'                  => 1,
                'name'                => 'Laborer 1 Name',
                'occupation'          => 'دكتور',
                'FK_occupation_id'    => 1,
                'nationality'         => 'مصري',
                'FK_nationality_id'   => 1,
                'FK_establishment_id' => 1,
                'gender'              => 1,
                'age'                 => 24,
                'religion'            => 1,
            ],
            [
                'id_number'           => '2020202020',
                'id'                  => 2,
                'name'                => 'Laborer 2 Name',
                'occupation'          => 'Occupation 2',
                'FK_occupation_id'    => 2,
                'nationality'         => 'Nationality 2',
                'FK_nationality_id'   => 2,
                'FK_establishment_id' => 1,
            ],
            [
                'id_number'           => '2649907546',
                'id'                  => 3,
                'name'                => 'Laborer 3 Name',
                'occupation'          => 'Occupation 3',
                'FK_occupation_id'    => 3,
                'nationality'         => 'Nationality 3',
                'FK_nationality_id'   => 3,
                'FK_establishment_id' => 1,
            ],
            [
                'id'                  => 4,
                'id_number'           => '2716634379',
                'name'                => 'Leased Laborer 1 Name',
                'occupation'          => 'Occupation 1',
                'FK_occupation_id'    => 1,
                'nationality'         => 'Nationality 1',
                'FK_nationality_id'   => 1,
                'FK_establishment_id' => 2,
            ],
            [
                'id_number'           => '2716634379',
                'id'                  => 3,
                'name'                => 'Pharmacist 1 Name',
                'occupation'          => 'صيدلي',
                'FK_occupation_id'    => 2322011,
                'nationality'         => 'مصري',
                'FK_nationality_id'   => 3,
                'FK_establishment_id' => 3,
            ],
        ]);
    }
    
    /**
     * @return Collection
     */
    private function users()
    {
        return collect([
            1 => 1010101010,
            2 => 1068212040,
        ]);
    }
    
    /**
     * @return Collection
     */
    private function jobs()
    {
        return collect([
            ['id' => 911330, 'name' => 'ابن مواطنة'],
            ['id' => 911080, 'name' => 'أب'],
            ['id' => 911150, 'name' => 'أب محرم'],
            ['id' => 911070, 'name' => 'أبن'],
            ['id' => 911220, 'name' => 'أبن الأخت محرم'],
            ['id' => 911100, 'name' => 'أبن الزوجة'],
            ['id' => 911210, 'name' => 'أبن محرم'],
            ['id' => 911090, 'name' => 'أخ'],
            ['id' => 911120, 'name' => 'أخ محرم'],
            ['id' => 911050, 'name' => 'ربة بيت'],
            ['id' => 911110, 'name' => 'مرافق'],
            ['id' => 6132035, 'name' => 'عامل تنظيف مستشفيات'],
            ['id' => 6132055, 'name' => 'عامل تنظيف سجاد'],
            ['id' => 6132075, 'name' => 'عامل منزلي'],
            ['id' => 6132085, 'name' => 'مساح احذية'],
            ['id' => 6132105, 'name' => 'مشرف خدمات عامة في سفينة'],
            ['id' => 9112145, 'name' => 'عامل تركيب مواسير عام'],
            ['id' => 9112165, 'name' => 'عامل تركيب مواسير سفنية'],
            ['id' => 9112175, 'name' => 'عامل تركيب'],
            ['id' => 9112205, 'name' => 'مشغل فرن الدست'],
            ['id' => 9112215, 'name' => 'عامل تشكيل مكبس المسبوك (ميكانيكيا)'],
            ['id' => 9113043, 'name' => 'مشغل مخرطة اتوماتيكية'],
            ['id' => 9113074, 'name' => 'مجلخ ادوات قطع'],
            ['id' => 9113105, 'name' => 'مساعد براد'],
            ['id' => 9113135, 'name' => 'مشغل الة تشغيل مبرمجة'],
            ['id' => 9113163, 'name' => 'مراقب على الانتاج في اعمال الخراطة'],
            ['id' => 9114034, 'name' => 'حداد اثاث معدني'],
            ['id' => 9114055, 'name' => 'مساعد حداد اثاث معدني'],
            ['id' => 9114075, 'name' => 'مشغل ثناية صفيح اليه'],
            ['id' => 9114215, 'name' => 'عامل صنع نماذج ارانيك معدنية السبك'],
            ['id' => 9114235, 'name' => 'عامل تصليح بنادق صيد'],
            ['id' => 9114255, 'name' => 'عامل تشكيل المعدن يدويا'],
            ['id' => 9116145, 'name' => 'عامل برشمة -ضغط هوائي'],
            ['id' => 9116155, 'name' => 'لحام المركبات المعدنية'],
            ['id' => 9116185, 'name' => 'عامل قطع باللهب يدويا'],
            ['id' => 9116195, 'name' => 'عامل قطع باللهب اليا'],
            ['id' => 9117015, 'name' => 'عامل تكسية'],
            ['id' => 9117025, 'name' => 'مشغل الة تكسية المعادن بالخارصين (مشغل الة جلفنة)'],
            ['id' => 9117045, 'name' => 'عامل تكسية معادن بالغمر'],
            ['id' => 9117065, 'name' => 'عامل تخمير (لحفر المعادن)'],
            ['id' => 9117075, 'name' => 'عامل مراجعة معادن'],
            ['id' => 9117095, 'name' => 'عامل طلاء بالغمس الساخن'],
            ['id' => 9117105, 'name' => 'عامل طلاء السلك بالماكينة'],
            ['id' => 9117125, 'name' => 'رباب اواني نحاسية'],
            ['id' => 9117135, 'name' => 'عامل طلاء المعادن بالازرق'],
            ['id' => 9117145, 'name' => 'عامل تنظيف المعادن المسبوكة وتنعيمها يدويا'],
            ['id' => 9117165, 'name' => 'عامل تنظيف المعادن بالرش بالمعادن'],
            ['id' => 9118024, 'name' => 'نحاس اوني منزلية'],
            ['id' => 9119013, 'name' => 'صانع حلي ومجوهرات عام'],
            ['id' => 9119043, 'name' => 'جواهرجي'],
            ['id' => 1217771, 'name' => 'مدير المعلومات التجارية والبحوث'],
            ['id' => 2311691, 'name' => 'استشاري طب المناطق الحارة'],
            ['id' => 2311701, 'name' => 'استشاري علم التشريح'],
            ['id' => 2312121, 'name' => 'استشاري جراحة قولون ومستقيم'],
            ['id' => 2312151, 'name' => 'استشاري جراحة اوعية دموية'],
            ['id' => 2312161, 'name' => 'استشاري جراحة دماغ واعصاب'],
            ['id' => 6411095, 'name' => 'خياطة منزلية'],
            ['id' => 6411192, 'name' => 'ممرضة منزلية'],
            ['id' => 6411145, 'name' => 'مزارع منزلي'],
            ['id' => 6411115, 'name' => 'طباخ منزلي'],
            ['id' => 2315361, 'name' => 'أخصائي أجهزة طبية'],
            ['id' => 1111081, 'name' => 'عضو مجلس إدارة'],
            ['id' => 3422012, 'name' => 'معلم'],
        ]);
    }
    
    /**
     * Get the nationality list.
     *
     * @return Collection
     */
    public function fetchNationalitiesLookup()
    {
        return collect([

        ]);
    }
}
