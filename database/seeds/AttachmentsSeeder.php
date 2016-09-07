<?php

use Illuminate\Database\Seeder;
use Tamkeen\Ajeer\Models\Attachment;

class AttachmentsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $attachments = [
            [
                'name' => 'رخصة القيادة',
            ],
            [
                'name' => 'الشهادة الصحية',
            ],
        ];
        
        foreach ($attachments as $attachment) {
            Attachment::create($attachment);
        }
    }
}
