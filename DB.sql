CREATE TABLE `categories`
(
    `id`          INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    `parent_id`   INT UNSIGNED DEFAULT NULL,
    `title`       VARCHAR(255)        NOT NULL,
    `slug`        VARCHAR(255) UNIQUE NOT NULL,
    `description` TEXT         DEFAULT NULL,
    `image`       TEXT         DEFAULT NULL,
    `created_at`  TIMESTAMP    DEFAULT CURRENT_TIMESTAMP,
    `updated_at`  TIMESTAMP    DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (`parent_id`) REFERENCES `categories` (`id`) ON DELETE SET NULL ON UPDATE SET NULL
);

CREATE TABLE `currencies`
(
    `id`         INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    `title`      VARCHAR(255),
    `code`       VARCHAR(255),
    `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    `updated_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
);

CREATE TABLE `products`
(
    `id`          INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    `title`       VARCHAR(255)        NOT NULL,
    `slug`        VARCHAR(255) UNIQUE NOT NULL,
    `description` TEXT         DEFAULT NULL,
    `image`       TEXT         DEFAULT NULL,
    `category_id` INT UNSIGNED DEFAULT NULL,
    `price`       FLOAT        DEFAULT 0,
    `currency_id` INT UNSIGNED DEFAULT NULL,
    `count`       INT UNSIGNED DEFAULT 0,
    `created_at`  TIMESTAMP    DEFAULT CURRENT_TIMESTAMP,
    `updated_at`  TIMESTAMP    DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (`category_id`) REFERENCES `categories` (`id`) ON DELETE SET NULL ON UPDATE SET NULL,
    FOREIGN KEY (`currency_id`) REFERENCES `currencies` (`id`) ON DELETE SET NULL ON UPDATE SET NULL
);

CREATE TABLE `orders`
(
    `id`           INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    `product_id`   INT UNSIGNED,
    `count`        INT UNSIGNED,
    `first_name`   VARCHAR(255),
    `last_name`    VARCHAR(255),
    `phone_number` VARCHAR(255),
    `city_name`    VARCHAR(255),
    `warehouses`   VARCHAR(255),
    `status`       ENUM ('new', 'in progress', 'completed', 'cancel'),
    `created_at`   DATETIME DEFAULT CURRENT_TIMESTAMP
);

/* НОВА ПОШТА */
CREATE TABLE `cities`
(
    `id`                 INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    `ref`                CHAR(36)     NOT NULL UNIQUE, -- Уникальный идентификатор города
    `name_ua`            VARCHAR(255) NOT NULL,        -- Название на украинском
    `name_ru`            VARCHAR(255) NOT NULL,        -- Название на русском
    `area_ref`           CHAR(36)     NOT NULL,        -- Уникальный идентификатор области
    `settlement_type`    CHAR(36)     NOT NULL,        -- Тип населенного пункта (город, село и т. д.)
    `latitude`           DECIMAL(10, 6) DEFAULT NULL,  -- Широта
    `longitude`          DECIMAL(10, 6) DEFAULT NULL,  -- Долгота
    `region`             VARCHAR(255)   DEFAULT NULL,  -- Область
    `region_ua`          VARCHAR(255)   DEFAULT NULL,  -- Название области (украинский)
    `region_ru`          VARCHAR(255)   DEFAULT NULL,  -- Название области (русский)
    `index1`             CHAR(10)       DEFAULT NULL,  -- Почтовый индекс (основной)
    `index2`             CHAR(10)       DEFAULT NULL,  -- Почтовый индекс (альтернативный)
    `index_coatsu`       CHAR(10)       DEFAULT NULL,  -- Код КОАТУУ
    `special_cash_check` TINYINT(1)     DEFAULT 0,     -- Спец. кассовый контроль (1 - да, 0 - нет)
    `has_warehouse`      TINYINT(1)     DEFAULT 0,     -- Есть ли отделение (1 - да, 0 - нет),
    `created_at`         DATETIME       DEFAULT CURRENT_TIMESTAMP
);

ALTER TABLE `cities` ADD INDEX (`name_ua`);

CREATE TABLE `warehouses`
(
    `id`                             INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    `site_key`                       VARCHAR(255)    NOT NULL,
    `description`                    VARCHAR(255)    NOT NULL,
    `description_ru`                 VARCHAR(255)    NOT NULL,
    `short_address`                  VARCHAR(255)    NOT NULL,
    `short_address_ru`               VARCHAR(255)    NOT NULL,
    `phone`                          VARCHAR(20)     NOT NULL,
    `type_of_warehouse`              CHAR(36)        NOT NULL,
    `ref`                            CHAR(36)        NOT NULL,
    `number`                         INT             NOT NULL,
    `city_ref`                       CHAR(36)        NOT NULL,
    `city_description`               VARCHAR(255)    NOT NULL,
    `city_description_ru`            VARCHAR(255)    NOT NULL,
    `settlement_ref`                 CHAR(36)        NOT NULL,
    `settlement_description`         VARCHAR(255)    NOT NULL,
    `settlement_area_description`    VARCHAR(255)    NOT NULL,
    `settlement_regions_description` VARCHAR(255)    NOT NULL,
    `settlement_type_description`    VARCHAR(255)    NOT NULL,
    `settlement_type_description_ru` VARCHAR(255)    NOT NULL,
    `longitude`                      DECIMAL(18, 12) NOT NULL,
    `latitude`                       DECIMAL(18, 12) NOT NULL,
    `created_at`                     DATETIME DEFAULT CURRENT_TIMESTAMP
);

ALTER TABLE `warehouses` ADD INDEX (`city_ref`);
/******/

INSERT INTO `currencies` (title, code)
VALUES ('Гривня', 'UAH');