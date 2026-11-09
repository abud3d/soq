# نشر NSHIR بجانب WordPress

GeoLite2: `/home/arbim/nshir.com/storage/geo/GeoLite2-City.mmdb`
وفي `.env`: `GEOIP_DB=/home/arbim/nshir.com/storage/geo/GeoLite2-City.mmdb`

## وضع التجربة
نقطة دخول NSHIR المؤقتة: `public/index2.php`.
لا تغيّر `DirectoryIndex` ولا rewrite الخاص بـ WordPress الآن.

## تثبيت
```bash
composer install --no-dev --optimize-autoloader
mysql nshir < database/schema.sql
mysql nshir < database/migrations/002_geo_ids.sql
mysql nshir < database/migrations/003_auth_notifications.sql
```

## الانتقال النهائي
بعد اعتماد النسخة: خذ نسخة احتياطية من WordPress وقاعدته و.htaccess، ثم اجعل NSHIR هو index.php وفعّل rewrite الخاص به. احتفظ بنسخة WordPress للرجوع السريع ولا تحذفه في لحظة التحويل نفسها.
