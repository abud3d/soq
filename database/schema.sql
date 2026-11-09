CREATE TABLE locations (
 id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
 parent_id BIGINT UNSIGNED NULL,
 type ENUM('country','city','area') NOT NULL,
 name VARCHAR(120) NOT NULL,
 slug VARCHAR(140) NOT NULL,
 sort_order INT NOT NULL DEFAULT 0,
 is_active TINYINT(1) NOT NULL DEFAULT 1,
 UNIQUE KEY uq_location_parent_slug(parent_id,slug),
 KEY idx_location_parent(parent_id,is_active,sort_order),
 CONSTRAINT fk_location_parent FOREIGN KEY(parent_id) REFERENCES locations(id) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

CREATE TABLE categories (
 id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
 parent_id BIGINT UNSIGNED NULL,
 name VARCHAR(120) NOT NULL,
 slug VARCHAR(140) NOT NULL,
 sort_order INT NOT NULL DEFAULT 0,
 is_active TINYINT(1) NOT NULL DEFAULT 1,
 UNIQUE KEY uq_category_parent_slug(parent_id,slug),
 KEY idx_category_parent(parent_id,is_active,sort_order),
 CONSTRAINT fk_category_parent FOREIGN KEY(parent_id) REFERENCES categories(id) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

CREATE TABLE users (
 id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
 email VARCHAR(190) NOT NULL UNIQUE,
 name VARCHAR(80) NOT NULL,
 password_hash VARCHAR(255) NOT NULL,
 country_id BIGINT UNSIGNED NOT NULL,
 city_id BIGINT UNSIGNED NULL,
 area_id BIGINT UNSIGNED NULL,
 registration_ip VARBINARY(16) NULL,
 last_login_ip VARBINARY(16) NULL,
 email_verified_at DATETIME NULL,
 verify_token_hash CHAR(64) NULL,
 reset_token_hash CHAR(64) NULL,
 reset_expires_at DATETIME NULL,
 status ENUM('active','blocked') NOT NULL DEFAULT 'active',
 created_at DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
 updated_at DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
 KEY idx_user_location(country_id,city_id,area_id)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

CREATE TABLE ads (
 id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
 user_id BIGINT UNSIGNED NOT NULL,
 category_id BIGINT UNSIGNED NOT NULL,
 country_id BIGINT UNSIGNED NOT NULL,
 city_id BIGINT UNSIGNED NULL,
 area_id BIGINT UNSIGNED NULL,
 title VARCHAR(160) NOT NULL,
 slug VARCHAR(190) NOT NULL,
 body TEXT NOT NULL,
 price DECIMAL(14,2) NULL,
 currency CHAR(3) NOT NULL DEFAULT 'SAR',
 publish_ip VARBINARY(16) NULL,
 status ENUM('published','hidden','sold','deleted') NOT NULL DEFAULT 'published',
 views BIGINT UNSIGNED NOT NULL DEFAULT 0,
 created_at DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
 updated_at DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
 KEY idx_ads_feed(status,created_at),
 KEY idx_ads_category(category_id,status,created_at),
 KEY idx_ads_location(country_id,city_id,area_id,status,created_at),
 CONSTRAINT fk_ads_user FOREIGN KEY(user_id) REFERENCES users(id),
 CONSTRAINT fk_ads_category FOREIGN KEY(category_id) REFERENCES categories(id)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

CREATE TABLE ad_images (
 id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
 ad_id BIGINT UNSIGNED NOT NULL,
 path VARCHAR(255) NOT NULL,
 width INT UNSIGNED NULL,
 height INT UNSIGNED NULL,
 sort_order SMALLINT UNSIGNED NOT NULL DEFAULT 0,
 created_at DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
 KEY idx_images_ad(ad_id,sort_order),
 CONSTRAINT fk_images_ad FOREIGN KEY(ad_id) REFERENCES ads(id) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

CREATE TABLE comments (
 id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
 ad_id BIGINT UNSIGNED NOT NULL,
 user_id BIGINT UNSIGNED NOT NULL,
 body VARCHAR(2000) NOT NULL,
 publish_ip VARBINARY(16) NULL,
 status ENUM('published','hidden','deleted') NOT NULL DEFAULT 'published',
 created_at DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
 KEY idx_comments_ad(ad_id,status,created_at),
 CONSTRAINT fk_comments_ad FOREIGN KEY(ad_id) REFERENCES ads(id) ON DELETE CASCADE,
 CONSTRAINT fk_comments_user FOREIGN KEY(user_id) REFERENCES users(id)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

CREATE TABLE notifications (
 id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
 user_id BIGINT UNSIGNED NOT NULL,
 type VARCHAR(50) NOT NULL,
 payload JSON NOT NULL,
 read_at DATETIME NULL,
 emailed_at DATETIME NULL,
 created_at DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
 KEY idx_notifications_user(user_id,read_at,created_at)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
