# نشر NSHIR

## GeoLite2 City
ضع قاعدة MaxMind خارج `public/`:

```
/home/arbim/nshir.com/storage/geo/GeoLite2-City.mmdb
```

ثم في `.env`:

```
GEOIP_DB=/home/arbim/nshir.com/storage/geo/GeoLite2-City.mmdb
```

الصلاحيات المقترحة: الملف قابل للقراءة لمستخدم PHP فقط، وليس للويب مباشرة.

## تثبيت
```bash
composer install --no-dev --optimize-autoloader
mysql nshir < database/schema.sql
mysql nshir < database/migrations/002_geo_ids.sql
mysql nshir < database/seed.sql
```

وجّه DocumentRoot إلى `public/`.

> لا تضف ملف MMDB إلى Git. قاعدة GeoLite تستخدم لاكتشاف موقع IP، بينما جدول locations هو المصدر الذي تعرض منه الأسماء العربية وروابط التصفح.
