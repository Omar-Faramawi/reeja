<?php

namespace Tamkeen\Ajeer\Console\Commands;

use Illuminate\Console\Command;
use Tamkeen\Ajeer\Models\Establishment;
use Tamkeen\Ajeer\Models\Government;
use Tamkeen\Ajeer\Models\Individual;
use Tamkeen\Ajeer\Models\TaqyeemTemplatePermission;
use Tamkeen\Ajeer\Utilities\Constants;

class SendNotifyEmail extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'dream:send_taqyeem';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Send Taqyeem notify email';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle() {
	    $taqyeemPermissions = TaqyeemTemplatePermission::with( 'specificUsers' )->get();

	    foreach ( $taqyeemPermissions as $permission ) {
		    foreach ( $permission->specificUsers as $user ) {
			    switch ($user->user_type) {
				    case Constants::USERTYPES['est']:
					    $userDetails = Establishment::with('responsibles')->find($user->user_id);
					    break;
				    case Constants::USERTYPES['gov'];
					    $userDetails = Government::find($user->user_id);
					    break;
				    default:
					    $userDetails = Individual::find($user->user_id);
					    break;
			    }


			    \Mail::send('emails.taqyem_template_notify', ['url' => url('rating/' . $permission->taqyeem_template_id ) ], function ($m) use ($userDetails, $user) {
				    $m->from(config('mail.from.address'), config('mail.from.name'));
				    if($user->user_type == Constants::USERTYPES['est'] && !$userDetails->responsibles->isEmpty()) {
					    $m->to($userDetails->responsibles[0]->responsible_email);
				    } else {
					    $m->to($userDetails->email);
				    }
				    $m->subject(trans('rating.added'));
			    });
			}

	    }

	    $this->info("Sent emails to the users");
    }
}
