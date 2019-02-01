<?php

/**
 * @category   Mangoit
 * @package    Mangoit_Custombanner
 */
$installer = $this;
$installer->startSetup();
$installer->run(
    "
-- DROP TABLE IF EXISTS {$this->getTable('custombanner')};
CREATE TABLE {$this->getTable('custombanner')} (
  `banner_id` int(11) unsigned NOT NULL auto_increment,
  `title` varchar(255) NOT NULL default '',
  `filename` varchar(255) NOT NULL default '',
  `link` varchar(255) NOT NULL default '',
  `banner_content` text NOT NULL default '',
  `status` smallint(6) NOT NULL default '0',
  `sort_order` int(11) NOT NULL default '0',
  `banner_type` TINYINT( 4 ) NOT NULL DEFAULT '0' COMMENT '0=>Image, 1=>HTML',
  `created_time` DATETIME NULL,
  `update_time` DATETIME NULL,
  PRIMARY KEY (`banner_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
 
-- DROP TABLE IF EXISTS {$this->getTable('custombannergroup')};
CREATE TABLE {$this->getTable('custombannergroup')} (
 `group_id` int(11) unsigned NOT NULL auto_increment,
 `group_name` varchar(255) NOT NULL default '',
 `group_code` varchar(255) NOT NULL default '',
 `banner_width` SMALLINT( 4 ) NOT NULL DEFAULT '0',
 `banner_height` SMALLINT( 4 ) NOT NULL DEFAULT '0',
 `animation_type` TINYINT( 4 ) NOT NULL DEFAULT '0' COMMENT '0=>Pre-defined, 1=> Custom Animation',
 `banner_effects` varchar(255) NOT NULL default '',
 `pre_custombanner_effects` varchar(255) NOT NULL default '',
 `banner_ids` varchar(255) NOT NULL default '',
 `show_title` TINYINT(4) NOT NULL default '0',
 `show_content` TINYINT(4) NOT NULL default '0',
 `link_target` TINYINT( 4 ) NOT NULL DEFAULT '0' COMMENT '0=>New Window, 1=> Self',
 `status` smallint(6) NOT NULL default '0',
 `created_time` DATETIME NULL,
 `update_time` DATETIME NULL,
 PRIMARY KEY (`group_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
"
);
$installer->endSetup();
