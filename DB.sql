CREATE TABLE `categories`
(
    `id`          INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    `parent_id`   INT UNSIGNED DEFAULT NULL,
    `title`        VARCHAR(255)        NOT NULL,
    `slug`        VARCHAR(255) UNIQUE NOT NULL,
    `description` TEXT         DEFAULT NULL,
    `image`       TEXT         DEFAULT NULL,
    `created_at`  TIMESTAMP    DEFAULT CURRENT_TIMESTAMP,
    `updated_at`  TIMESTAMP    DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (parent_id) REFERENCES categories (`id`) ON DELETE CASCADE
);
