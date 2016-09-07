<?php
return [
    'cannotaccept'   => "You can't accept this offer",
    "requestApprove" => "Are you sure you want accept this offer ?",
    "accepted"       => "Accepted Successfully ",
    "modal"          => [
        "reject" => [
            "rejectTitle"    => "Request Rejection",
            "requestApprove" => "Are you sure to reject this request ?"
        ],
    ],
    "rejected"       => "Request rejected ",
    "mail"           => [
        "provider" => [
            "reject" => [
                "subject"             => "Your request rejected",
                "yourrequestrejected" => "Dear :providerName, we are sorry to inform you that your sponsor rejected your request",
            ]
        ],
        "benf"     => [
            "reject" => [
                "subject"             => "Your request approved and waiting for sponsor approval",
                "yourrequestrejected" => "Dear :benfName, We are sorry to inform you that you request to employ :providerName is rejected by his/here sponsor",
            ]
        ],
    ],
];