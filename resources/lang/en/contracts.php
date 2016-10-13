<?php

return [
    'contracts'            => 'Contracts',
    'edit_contract'        => 'Edit offer',
    'edit_contract_data'   => 'Edit Contract',
    'save'                 => 'Save',
    'reset'                => 'Reset',
    'reset_back'           => 'Revert Cancellation',
    'reset_back_reason'    => 'Revert Cancellation reason',
    'employee_signed'      => 'Employee Signed',
    "contractDetails"      => "Contract Details",
    "contractStatus"       => "Contract Status",
    'id'                   => 'Contract Number',
    'work_completion_cert' => 'Generate Work Completion Certificate',
    'details_contract'     => 'Contract Details',
    'cancel_reason'        => 'Cancel Reason',
    'can_delete'           => 'Contract status must be approved or under editing',
    'others'               => 'Other reasons',
    'reason'               => 'Reason',
    'reason_id'            => 'Reason',
    'ids_missing'          => 'Employees',
    'rejection_reason'     => 'Contract Rejection Reason',
    'updated'              => 'Updated',
    'status'               => 'Contact Satus',
    'statuses'             => [
        'requested'         => 'Requested',
        'pending'           => 'Pending',
        'rejected'          => 'Rejected',
        'pending_ownership' => 'Pending Ownership Approval',
        'approved'          => 'Approved',
        'cancelled'         => 'Cancelled',
        'benef_cancel'      => 'Cancelled by Beneficial',
        'provider_cancel'   => 'Cancelled by Provider',
    ],
    'attributes'           => [
        'start_date' => 'Work Start Date',
        'end_date'   => 'Work End Date',
    ],
    'undo_invoice_notice'  => '<strong>Note: </strong> In case you have generated an invoice and needed to undo this action, you will have to wait 3 days till the invoice expires, then it is declined automatically',
    'action_buttons'       => [
        'send_offer'              => 'Send Offer',
        'reject_request'          => 'Reject Request',
        'edit_offer'              => 'Edit Offer',
        'edit_request'            => 'Edit Request',
        'cancel_offer'            => 'Cancel Offer',
        'generate_ishaar'         => 'Generate Notice',
        'cancel_ishaar'           => 'Cancel Notice',
        'request_contract_cancel' => 'Cancel contract request',
        'request_contract_ishaar' => 'Cancel notice request',
        'rate_benf'               => 'Rate service beneficial',
        'process_cancel_request'  => 'Cancel Request',
        'revert_cancel'           => 'Revert Cancellation',
        'print_ishaar'            => 'Print Notice',
        'rate_provider'           => 'Rate service provider',
        'view_offer'              => 'View Offer',
    ],
    'status_alias'         => [
        '1' => [
            'requested'                => 'Request to send offer',
            'pending_acc'              => 'Sent offer - Pending approval',
            'pending'                  => 'Received request - Pending offer',
            'rejected'                 => 'Reject offer',
            'pending_ownership'        => 'Pending work owner approval',
            'approved_without_ishaar'  => 'Approved offer - Approved Contract',
            'approved'                 => 'Approved Contract - Has Notice',
            'cancelled'                => 'Cancelled Contract',
            'benef_cancel'             => 'Received contract cancel request - pending approval',
            'provider_cancel'          => 'Sent contract cancel request - pending approval',
            'provider_cancel_employee' => 'Sent notice cancel request - pending approval',
            'benef_cancel_employee'    => 'Received notice cancel request - pending approval',
            'approved_finished'        => 'Finished contract',
        ],
        '2' => [
            'requested'                => 'Request to send offer',
            'pending_acc'              => 'Received offer - pending approval',
            'pending'                  => 'Sent request - pending offer',
            'rejected'                 => 'Rejected offer',
            'pending_ownership'        => 'Pending work owner approval',
            'approved_without_ishaar'  => 'Approved Contract - pending notice',
            'approved'                 => 'Approved Contract - Has Notice',
            'cancelled'                => 'Cancelled Contract',
            'provider_cancel'          => 'Received contract cancel request - pending approval',
            'benef_cancel'             => 'Received contract cancel request - pending approval',
            'provider_cancel_employee' => 'Sent notice cancel request - pending approval',
            'benef_cancel_employee'    => 'Received notice cancel request - pending approval',
            'approved_finished'        => 'Finished contract',
        ],
    ],
];