CREATE TABLE `xrest_tables` (
    `tbl_id`        INT(20) UNSIGNED NOT NULL AUTO_INCREMENT,
    `tablename`     VARCHAR(220) DEFAULT NULL,
    `allowpost`     TINYINT(2)   DEFAULT '0',
    `allowretrieve` TINYINT(2)   DEFAULT '0',
    `allowupdate`   TINYINT(2)   DEFAULT '0',
    `visible`       TINYINT(2)   DEFAULT '0',
    `view`          TINYINT(2)   DEFAULT '0',
    PRIMARY KEY (`tbl_id`)
);

CREATE TABLE `xrest_fields` (
    `fld_id`        INT(30) UNSIGNED NOT NULL AUTO_INCREMENT,
    `tbl_id`        INT(20)      DEFAULT '0',
    `key`           TINYINT(2)   DEFAULT '0',
    `fieldname`     VARCHAR(220) DEFAULT NULL,
    `allowpost`     TINYINT(2)   DEFAULT '0',
    `allowretrieve` TINYINT(2)   DEFAULT '0',
    `allowupdate`   TINYINT(2)   DEFAULT '0',
    `visible`       TINYINT(2)   DEFAULT '0',
    `string`        TINYINT(2)   DEFAULT '0',
    `int`           TINYINT(2)   DEFAULT '0',
    `float`         TINYINT(2)   DEFAULT '0',
    `text`          TINYINT(2)   DEFAULT '0',
    `other`         TINYINT(2)   DEFAULT '0',
    `crc`           TINYINT(2)   DEFAULT '0',
    PRIMARY KEY (`fld_id`)
);

CREATE TABLE `xrest_plugins` (
    `plugin_id`   INT(10) UNSIGNED NOT NULL AUTO_INCREMENT,
    `plugin_name` VARCHAR(255) DEFAULT NULL,
    `plugin_file` VARCHAR(255) DEFAULT NULL,
    `active`      TINYINT(2)   DEFAULT '0',
    PRIMARY KEY (`plugin_id`)
);
