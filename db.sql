-- members definition
DROP TABLE IF EXISTS members;
CREATE TABLE `members`
(
    `id`       bigint                                  NOT NULL AUTO_INCREMENT,
    `username` varchar(50) COLLATE utf8mb4_general_ci  NOT NULL,
    `password` text COLLATE utf8mb4_general_ci         NOT NULL,
    `email`    varchar(100) COLLATE utf8mb4_general_ci NOT NULL,
    `token`    varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
    PRIMARY KEY (`id`)
) ENGINE = InnoDB
  DEFAULT CHARSET = utf8mb4
  COLLATE = utf8mb4_general_ci;

-- urls definition
DROP TABLE IF EXISTS urls;
CREATE TABLE `urls`
(
    `id`        bigint                                  NOT NULL AUTO_INCREMENT,
    `url`       text COLLATE utf8mb4_general_ci         NOT NULL,
    `url_short` varchar(100) COLLATE utf8mb4_general_ci NOT NULL,
    `date`      datetime                                NOT NULL,
    `username`  varchar(50) COLLATE utf8mb4_general_ci  NOT NULL,
    PRIMARY KEY (`id`),
    UNIQUE KEY `urls_UN` (`url_short`)
) ENGINE = InnoDB
  DEFAULT CHARSET = utf8mb4
  COLLATE = utf8mb4_general_ci;