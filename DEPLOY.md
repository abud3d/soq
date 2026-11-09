# بنية NSHIR المعتمدة

جذر المشروع (خارج الويب قدر الإمكان):
```
nshir/
├── .env
├── composer.json
├── vendor/
├── src/
├── database/
├── scripts/
├── storage/
│   ├── geo/GeoLite2-City.mmdb
│   └── uploads/
└── public/
    ├── index2.php
    ├── health.php
    ├── assets/
    └── ad/
        └── media.php
```

## أثناء التجربة مع WordPress
إذا كان DocumentRoot الحالي لا يزال جذر WordPress، لا تغيّره بعد. انشر المشروع في مسار مستقل واستخدم إعداد السيرفر/alias المناسب للوصول إلى public للاختبار. لا تكشف .env أو src أو vendor أو storage للويب.

## عند الاعتماد النهائي
غيّر DocumentRoot للدومين إلى `nshir/public` فقط. هذه أفضل من وضع المشروع كله داخل public: المتصفح لا يستطيع طلب `.env` أو `storage/geo` أو كود التطبيق مباشرة.

تغيير DocumentRoot وعزل الملفات يقلل سطح الهجوم، لكنه ليس حماية DDoS. لحماية البوتات والهجمات الحجمية استخدم CDN/WAF أمام الخادم، مع rate limiting على التطبيق والخادم.

GeoLite2 يبقى خارج public في `storage/geo/GeoLite2-City.mmdb`.
