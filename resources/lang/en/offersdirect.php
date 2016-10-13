<?php
return [
    "receivedOffers"          => "Received Offers",
    "providerName"            => "Provider Name",
    "job"                     => "Job",
    "gender"                  => "Gender",
    "religion"                => "Religion",
    "region"                  => "Region",
    "workStartDate"           => "Work Start Date",
    "workEndDate"             => "work End Date",
    "details"                 => "details",
    "browseOffer"             => "Browse Offer",
    "offerDetails"            => "Offer Details",
    "providerInfo"            => "Provider Information",
    "providerType"            => "Provider Type",
    "benfInfo"                => "Beneficial Info",
    "benfNo"                  => "Beneficial Number",
    "benfName"                => "Beneficial Name",
    "requestDetails"          => "Offer Details",
    "nationality"             => "Nationality",
    "jobtype"                 => "Job Type",
    "salary"                  => "Salary",
    "workplaces"              => "Work Places",
    "error"                   => "Error",
    "accept"                  => "Accept",
    "decline"                 => "Decline",
    "qualifications"          => "Certifications",
    "offerValideTo"           => "Offer Valid until",
    "offerValideToDescrition" => "Calculated Automatically depends to administrator inputs",
    "acceptRules"             => "I accept rules",
    "errorDetails"            => "you don't allowed to enter this page",
    "cannotaccept"            => "You can;t accept this offer",
    "accepted"                => "Offer Accepted Successfully",
    'loading'                 => 'Loading',
    "modal"                   => [
        "accept" => [
            "title"                 => "Accept Offer",
            "rules"                 => "Rules",
            "rulesDetails"          => "Rules Here ",
            "approve"               => "Approve",
            "cancel"                => "Cancel",
            "contractTitle"         => "Contract",
            "contractTemplate"      => "Contract Written",
            "message"               => "you should accept rules",
            "qualificationsmessage" => "you should upload your certifications",
            "offerAccepted"         => "offer accepted Successfully",

        ],
        "reject" => [
            "title"          => "reject offer",
            "reason"         => "rejection reason",
            "reasonRequired" => "you should select rejection reason",
            "other"          => "other",
            "other_reason"   => "You Must Fill Other Reason Field",
            "extraDetails"   => "Extra details",
            "send"           => "Send",
            "rejectionSuc"   => "Offer rejected successfully",
            "message"        => "you should select rejection reason",
            "mail"           => [
                "subject" => "your offer rejected",
            ],

        ],
        "close"  => "Close"
    ],

    "smsmessage"              => "Message include  :link",
    "mail"                    => [
        "provider" => [
            "reject" => [
                "yourrequestrejected" => "Dear :benfName The memeber  :providerName rejected your request",
            ]
        ],
        "benf"     => [
            "pendingownership" =>
                [
                    "yourrequestaccepted" => "Dear :benfName  The Member :providerName approved your request and your request is wating now for his/here sponsor approval",
                ]
        ],
    ],
    "pending_ownership_error" => "This offer is pending sponsor approval",
    "offer_rejected"          => "Offer Rejected",
    "offer_approved"          => "Offer already approved",
];