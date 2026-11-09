INSERT INTO locations(parent_id,type,name,slug,sort_order) VALUES
(NULL,'country','السعودية','saudi-arabia',1),(NULL,'country','الكويت','kuwait',2),(NULL,'country','الإمارات','uae',3);
SET @sa=LAST_INSERT_ID()-2;
INSERT INTO locations(parent_id,type,name,slug,sort_order) VALUES
(@sa,'city','الرياض','riyadh',1),(@sa,'city','مكة المكرمة','makkah',2),(@sa,'city','المدينة المنورة','madinah',3),(@sa,'city','المنطقة الشرقية','eastern',4);
SET @riyadh=LAST_INSERT_ID()-3;
INSERT INTO locations(parent_id,type,name,slug,sort_order) VALUES
(@riyadh,'area','الرياض','riyadh-city',1),(@riyadh,'area','الخرج','alkharj',2),(@riyadh,'area','الدرعية','diriyah',3);

INSERT INTO categories(parent_id,name,slug,sort_order) VALUES
(NULL,'عقارات','real-estate',1),(NULL,'سيارات','cars',2),(NULL,'إلكترونيات','electronics',3),(NULL,'حيوانات','animals',4);
SET @re=LAST_INSERT_ID()-3;
INSERT INTO categories(parent_id,name,slug,sort_order) VALUES
(@re,'فلل','villas',1),(@re,'أراضي','land',2),(@re,'شقق','apartments',3);
SET @villas=LAST_INSERT_ID()-2;
INSERT INTO categories(parent_id,name,slug,sort_order) VALUES
(@villas,'دور واحد','one-floor',1),(@villas,'دورين','two-floors',2);
SET @two=LAST_INSERT_ID();
INSERT INTO categories(parent_id,name,slug,sort_order) VALUES
(@two,'بيع','sale',1),(@two,'إيجار','rent',2);
