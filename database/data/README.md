# بيانات المواقع الجغرافية

ضع ملف المواقع الكامل هنا بدل تضخيم `database/seed.sql`.

الصيغة المفضلة: `locations.csv` بترميز UTF-8:

```csv
country_code,country_ar,region_code,region_ar,city_code,city_ar,governorate_code,governorate_ar
SA,السعودية,01,منطقة الرياض,001,الرياض,00101,الدرعية
```

- يمكن ترك المحافظة فارغة إذا لم توجد.
- الأكواد أهم من الأسماء لربط السجلات ومنع التكرار.
- الأسماء العربية هي التي تظهر للمستخدم.
- لا ترفع ملفًا مجهول الترخيص إلى المستودع العام قبل التأكد من ترخيصه.
- للاستيراد شغّل: `php scripts/import-locations.php database/data/locations.csv`
