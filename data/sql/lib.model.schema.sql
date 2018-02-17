# This is a fix for InnoDB in MySQL >= 4.1.x
# It "suspends judgement" for fkey relationships until are tables are set.
SET FOREIGN_KEY_CHECKS = 0;

#-----------------------------------------------------------------------------
#-- videofile
#-----------------------------------------------------------------------------

DROP TABLE IF EXISTS `videofile`;


CREATE TABLE `videofile`
(
  `id`          INTEGER(11) NOT NULL AUTO_INCREMENT,
  `type`        VARCHAR(255),
  `url`         VARCHAR(255),
  `title`       VARCHAR(255),
  `description` TEXT        NOT NULL,
  `created_at`  DATETIME,
  `updated_at`  DATETIME,
  PRIMARY KEY (`id`)
)
  ENGINE = InnoDB;

# This restores the fkey checks, after having unset them earlier
SET FOREIGN_KEY_CHECKS = 1;
