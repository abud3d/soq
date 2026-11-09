# رفع NSHIR التجريبي بجانب WordPress

## لا تحذف WordPress الآن
اترك `index.php` وملفات WordPress كما هي. نقطة دخول NSHIR هي `index2.php` فقط، والنسخة التجريبية تحمل `noindex,nofollow`.

## المتطلبات
PHP 8.2+ مع: PDO MySQL, mbstring, fileinfo, GD مع WebP. Composer متاح على السيرفر.

GeoLite2:
`storage/geo/GeoLite2-City.mmdb`

## الإعداد
انسخ `.env.example` إلى `.env` وعدّل قاعدة البيانات وAPP_URL. ثم:
```bash
composer install --no-dev --optimize-autoloader
mysql -u USER -p DATABASE < database/schema.sql
mysql -u USER -p DATABASE < database/migrations/002_geo_ids.sql
mysql -u USER -p DATABASE < database/migrations/003_auth_notifications.sql
mysql -u USER -p DATABASE < database/seed.sql
mkdir -p storage/uploads storage/geo
chmod 750 storage storage/uploads storage/geo
```

## اختبار
افتح `https://nshir.com/index2.php`.
اختبر التسجيل، وصول رسالة التفعيل، الدخول، النشر مع صورة، فتح الصورة، التعليق، الإشعار، واستعادة كلمة المرور.

إذا لم تصل الرسائل، فدالة PHP mail غير مهيأة في الاستضافة ويجب ربط SMTP قبل الإطلاق العام.

## الانتقال النهائي
بعد الاعتماد فقط: نسخة احتياطية من WordPress وقاعدته و.htaccess، تحويل front controller إلى NSHIR، تفعيل الروابط النظيفة وSEO/sitemap، ثم إبقاء نسخة WordPress للرجوع قبل حذفه لاحقًا.
