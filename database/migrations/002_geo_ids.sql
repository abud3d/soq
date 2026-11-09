ALTER TABLE locations
 MODIFY type VARCHAR(24) NOT NULL,
 ADD COLUMN country_code CHAR(2) NULL AFTER type,
 ADD COLUMN subdivision_code VARCHAR(12) NULL AFTER country_code,
 ADD COLUMN geoname_id BIGINT UNSIGNED NULL AFTER subdivision_code,
 ADD COLUMN name_en VARCHAR(160) NULL AFTER name,
 ADD UNIQUE KEY uq_location_geoname(geoname_id),
 ADD KEY idx_location_codes(country_code,subdivision_code);
