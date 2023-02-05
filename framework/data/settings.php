<?php
    $settings = array(
        "site.name"                 => "MTG Collectioner",
        "site.devel"				=> true,
        "site.url"                  => "http://localhost",
        "locales"                   => array("en", "es"),
        "currencies"                => array("currency_eur" => "&#8364;", "currency_dollar" => "&#x24;"),

        "notifications_max_count"   => 99,

        "validators.password_length"=> 6,
        "validators.username_length"=> 15,
        "validators.name_length"=> 18,

        "upload.img.path"           => "cards/uploads/",
        "upload.fileTypes"          => array("jpg", "png", "jpeg", "gif"),
        "upload.maxSize"            => 10000000,
        "default.profile.img"       => "/cards/assets/img/default_profile.png",
        
        "mysql.host"			    => "localhost",
        "mysql.user"			    => "root",
        "mysql.pass"			    => "",
        "mysql.db"				    => "carddatabase",

        "mail.host"                 => "authsmtp.securemail.pro",
        "mail.user"                 => "no-reply@mtgcollectioner.com",
        "mail.pass"                 => "Collectioner@25005",
        "mail.port"                 => 465,

        "google.clientId"           => "139625311466-b9pjigt84q9sfqri2h856svougc1m482.apps.googleusercontent.com",
        "google.clientSecret"       => "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",

        "twitter.clientId"           => "BVjvHzHBoeBCq7zZ8NkmuwyHA",
        "twitter.clientSecret"       => "yC0WFFmV8AsSVZEdYRBBJJnv68dnK1QxAKZJm7hYzAxs2vxbcq",

        "discord.clientId"          => "1067717804956069888",
        "discord.clientSecret"      => "uBbAaatclv0Vp6rKjvvdEWTOvNKk3e9C",
        "discord.scopes"            => "identify+email",

        //Dashboard
        "cards.numPerPage"          => 6,
        "cards.colors"              => array("W", "U", "B", "G", "R", ""),
        "formats"                   => array("Standard", "Modern", "Pioneer", "Historic", "Alchemy", "Pauper"),
    
        "publications.numPerLoad"   => 5
    );
?>