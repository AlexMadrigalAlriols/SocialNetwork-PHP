<?php
    $settings = array(
        "site.name"                 => "MTG Collectioner",
        "site.devel"				=> true,
        "site.url"                  => "http://mtgcollectioner.com",
        "locales"                   => array("en", "es"),
        "currencies"                => array("currency_eur" => "&#8364;", "currency_dollar" => "&#x24;"),

        "upload.img.path"           => "cards/uploads/",
        "default.profile.img"       => "/cards/assets/img/default_profile.png",
        
        "mysql.host"			    => "localhost",
        "mysql.user"			    => "root",
        "mysql.pass"			    => "",
        "mysql.db"				    => "carddatabase",

        "mail.host"                 => "smtp.gmail.com",
        "mail.user"                 => "alex25005.lleida@gmail.com",
        "mail.pass"                 => "kuqfygvzxeehygzy",
        "mail.port"                 => 465,

        //Dashboard
        "cards.numPerPage"          => 6,
        "cards.colors"              => array("W", "U", "B", "G", "R", ""),
        "formats"                   => array("Standard", "Modern", "Pioneer", "Historic", "Alcehmy", "Pauper"),
    
        "publications.numPerLoad"   => 5
    );
?>