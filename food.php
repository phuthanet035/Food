<?php
ini_set('display_errors', '1');
error_reporting(E_ALL);

require_once 'ClassFoodMenu.php';
require_once 'ClassFoodType.php';
require_once 'ClassRecipes.php';
require_once 'ClassFoodRepository.php';

$foodRepo = new FoodRepository();
$allRawMenus = $foodRepo->getAllMenus();

$specialRecipes = [
    'คั่วพริกเกลือ' => new Recipes(
        'รากผักชีสับละเอียด, กระเทียมสับ, พริกขี้หนูสับหยาบ, เกลือ, ผงปรุงรส, ผักชีซอย',
        '5 ราก, 5 กลีบ, 10 เม็ด, 1/2 ช้อนชา, 1 ช้อนโต๊ะ, 1 ต้น'
    ),
    'กะเพราแห้ง' => new Recipes(
        'พริกสด, กระเทียมกลีบเล็ก, น้ำมันพืช, พริกไทยป่น, ผงปรุงรส, น้ำตาลทราย, ซอสหอยนางรม, ซอสปรุงรส, ใบกะเพรา',
        '6 เม็ด, 2 ช้อนโต๊ะ, 2 ช้อนโต๊ะ, 1 ช้อนชา, 1/2 ช้อนชา, 1 ช้อนชา, 1 ช้อนโต๊ะ, 1/2 ช้อนโต๊ะ, ตามชอบ'
    ),
    'ผัดกระเทียมพริกไทย' => new Recipes(
        'กระเทียม, น้ำมันหอย, ซีอิ๊วขาว, น้ำตาล, น้ำมัน, พริกไทย, ผักชี',
        '1/2 ถ้วยตวง, 1 ช้อนโต๊ะ, 2 ช้อนโต๊ะ, 1 ช้อนชา, 1 ช้อนโต๊ะ, โรยหน้า, สำหรับแต่งหน้า'
    ),
    'ผัดขี้เมา' => new Recipes(
        'พริกไทยสด, พริกชี้ฟ้าแดง, กระเทียมสับ, ข้าวโพดอ่อน, ใบมะกรูด, ใบกะเพรา, น้ำตาลทราย, น้ำมันหอย, น้ำเปล่า, น้ำมันพืช',
        '2-3 พวง, 4 เม็ด, 4 กลีบ, 5 ฝัก, 5 ใบ, 1 กำ, 1/2 ช้อนโต๊ะ, 1 ช้อนโต๊ะ, 1/2 ช้อนโต๊ะ, 1 ช้อนโต๊ะ'
    ),
    'ผัดผงกะหรี่' => new Recipes(
        'ผงกะหรี่, น้ำพริกเผา, กระเทียมสับ, ซอสปรุงรส, น้ำตาลทราย, ซีอิ๊วขาว, ซอสเห็ดหอม, นมข้นจืด, น้ำเปล่า, น้ำมันพืช',
        '2 ช้อนโต๊ะ, 1 ช้อนโต๊ะ, 1 ช้อนโต๊ะ, 1/2 ช้อนโต๊ะ, 1 ช้อนโต๊ะ, 1 ช้อนโต๊ะ, 3 ช้อนโต๊ะ, 1/4 ถ้วยตวง, 1/4 ถ้วยตวง, 1 ช้อนโต๊ะ'
    ),
    'ผัดพริกแกง' => new Recipes(
        'ถั่วฝักยาวหั่น, น้ำมันพืช, น้ำพริกแกงเผ็ด, น้ำปลา, น้ำตาลทราย, ใบมะกรูดซอย, พริกชี้ฟ้าแดง',
        '1 ถ้วย, 2 ช้อนโต๊ะ, 1-2 ช้อนโต๊ะ, 1 ช้อนโต๊ะ, 1/2 ช้อนโต๊ะ, 3 ใบ, ตกแต่ง'
    )
];

$displayMenus = [];
foreach ($allRawMenus as $id => $menuData) {
    $menuName = $menuData['name'];
    
    $matchedRecipe = null;
    foreach ($specialRecipes as $keyword => $recipeObj) {
        if (str_contains($menuName, $keyword)) {
            $matchedRecipe = $recipeObj;
            break;
        }
    }

    $displayMenus[$id] = [
        'menu' => new FoodMenu($menuName),
        'type' => new FoodType($menuData['type']),
        'recipes' => $matchedRecipe
    ];
}
?>

<!DOCTYPE html>
<html lang="th">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>📖 คลังสูตรอาหาร 100 เมนูยอดฮิต</title>
    <style>
        :root {
            --bg-one: #ff7675;
            --bg-two: #fdcb6e;
            --bg-three: #74b9ff;
        }

        body {
            background-color: #f8f9fa;
            margin: 0;
            padding: 20px;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            color: #2d3436;
        }
        
        .container {
            max-width: 1400px;
            margin: 0 auto;
        }

        header {
            text-align: center;
            margin-bottom: 30px;
        }

        header h1 {
            margin: 10px 0;
            font-size: 2rem;
            color: #2d3436;
        }

        /* 💡 UX Improvement: ส่วนของ Tab สลับหมวดหมู่ */
        .tabs {
            display: flex;
            justify-content: center;
            gap: 10px;
            margin-bottom: 30px;
            flex-wrap: wrap;
        }

        .tab-btn {
            padding: 12px 24px;
            border: none;
            background: #fff;
            color: #636e72;
            font-size: 1rem;
            font-weight: bold;
            border-radius: 30px;
            cursor: pointer;
            box-shadow: 0 2px 5px rgba(0,0,0,0.05);
            transition: all 0.2s ease;
        }

        .tab-btn:hover {
            transform: translateY(-2px);
            box-shadow: 0 4px 10px rgba(0,0,0,0.1);
        }

        /* สไตล์ปุ่มแต่ละหมวดเมื่อถูก Active */
        .tab-btn[data-target="all"].active { background: #2d3436; color: #fff; }
        .tab-btn[data-target="one"].active { background: var(--bg-one); color: #fff; }
        .tab-btn[data-target="two"].active { background: var(--bg-two); color: #2d3436; }
        .tab-btn[data-target="three"].active { background: var(--bg-three); color: #fff; }

        /* จัด Grid แสดงผล */
        .menu-grid {
            display: grid;
            grid-template-columns: repeat(4, 1fr);
            gap: 20px;
        }

        /* 💡 UI Improvement: การ์ดแบบใหม่ มินิมอล ดูสบายตาขึ้น */
        .card {
            background: white;
            border-radius: 16px;
            padding: 20px;
            box-shadow: 0 4px 12px rgba(0,0,0,0.03);
            display: flex;
            flex-direction: column;
            border-top: 6px solid #ccc;
            transition: all 0.25s ease;
        }

        .card:hover {
            transform: translateY(-5px);
            box-shadow: 0 8px 20px rgba(0,0,0,0.08);
        }

        /* คัดแยกสีตามหมวดหมู่ */
        .card.cat-one { border-top-color: var(--bg-one); }
        .card.cat-two { border-top-color: var(--bg-two); }
        .card.cat-three { border-top-color: var(--bg-three); }

        .menu-number {
            font-size: 0.8rem;
            color: #b2bec3;
            font-weight: 600;
        }

        .card-header h3 {
            margin: 6px 0;
            color: #2d3436;
            font-size: 1.2rem;
            line-height: 1.4;
        }
        
        .food-type {
            display: inline-block;
            font-size: 0.75rem;
            padding: 4px 10px;
            border-radius: 12px;
            margin-bottom: 15px;
            font-weight: bold;
        }
        .cat-one .food-type { background: #ffeaa7; color: #d63031; }
        .cat-two .food-type { background: #fff9db; color: #f59f00; }
        .cat-three .food-type { background: #dff9fb; color: #0984e3; }

        .recipe-list {
            flex-grow: 1;
            font-size: 0.9rem;
        }

        .row {
            display: flex;
            justify-content: space-between;
            padding: 5px 0;
            border-bottom: 1px dashed #f1f2f6;
        }
        .material { color: #2d3436; }
        .unit { color: #636e72; font-weight: 500; }

        /* 💡 UX: ปรับข้อความไม่มีส่วนผสมให้อ่อนลง ไม่แย่งสายตา */
        .no-recipe {
            color: #c8d6e5;
            font-size: 0.85rem;
            text-align: center;
            padding: 15px 0;
            border: 1px dashed #eee;
            border-radius: 8px;
            background: #fafafa;
        }

        /* ซ่อนการ์ดที่ไม่เกี่ยวข้องกับการกด Tab */
        .card.hidden {
            display: none !important;
        }

        /* Responsive */
        @media (max-width: 1200px) { .menu-grid { grid-template-columns: repeat(3, 1fr); } }
        @media (max-width: 900px) { .menu-grid { grid-template-columns: repeat(2, 1fr); } }
        @media (max-width: 600px) { .menu-grid { grid-template-columns: 1fr; } }
    </style>
</head>
<body>

    <div class="container">
        <header>
            <h1>📖 คลังสูตรอาหาร 100 รายการ</h1>
        </header>

        <!-- ส่วนของแถบตัวเลือกเพื่อความง่ายในการใช้งาน (UX) -->
        <div class="tabs">
            <button class="tab-btn active" data-target="all">ทั้งหมด (100)</button>
            <button class="tab-btn" data-target="one">ข้าวจานเดียว (50)</button>
            <button class="tab-btn" data-target="two">เมนูเส้น (26)</button>
            <button class="tab-btn" data-target="three">ต้ม แกง และอื่นๆ (24)</button>
        </div>

        <div class="menu-grid">
            <?php foreach ($displayMenus as $id => $item): 
                $foodMenu = $item['menu'];
                $foodType = $item['type'];
                $recipes  = $item['recipes'];
                
                // คัดแยกประเภทเพื่อจับคู่คลาส CSS
                $rawType = $foodType->getTypeName();
                if ($rawType === 'ข้าวจานเดียว') {
                    $catClass = 'cat-one';
                } elseif ($rawType === 'เมนูเส้น') {
                    $catClass = 'cat-two';
                } else {
                    $catClass = 'cat-three';
                }
            ?>
                <div class="card <?php echo $catClass; ?>">
                    <span class="menu-number">เมนูที่ <?php echo $id; ?></span>
                    <div class="card-header">
                        <h3><?php echo htmlspecialchars($foodMenu->getName()); ?></h3>
                    </div>
                    <div>
                        <span class="food-type"><?php echo htmlspecialchars($rawType); ?></span>
                    </div>
                    
                    <div class="recipe-list">
                        <?php if ($recipes !== null): 
                            $materials = $recipes->getMaterials();
                            $units     = $recipes->getUnits();
                            foreach ($materials as $index => $materialName): 
                                $unitName = isset($units[$index]) ? $units[$index] : '';
                        ?>
                                <div class="row">
                                    <span class="material"><?php echo htmlspecialchars($materialName); ?></span>
                                    <span class="unit"><?php echo htmlspecialchars($unitName); ?></span>
                                </div>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <div class="no-recipe">💡 สูตรอาหารพื้นฐานทั่วไป</div>
                        <?php endif; ?>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    </div>

    <!-- 💡 UX Script: ช่วยให้กดสลับ Tab ได้ทันทีโดยไม่ต้องโหลดหน้าจอใหม่ -->
    <script>
        document.querySelectorAll('.tab-btn').forEach(button => {
            button.addEventListener('click', () => {
                // เปลี่ยนสถานะปุ่ม Active
                document.querySelectorAll('.tab-btn').forEach(btn => btn.classList.remove('active'));
                button.classList.add('active');

                const target = button.getAttribute('data-target');
                
                // จัดการการแสดงผลของการ์ด
                document.querySelectorAll('.card').forEach(card => {
                    if (target === 'all') {
                        card.classList.remove('hidden');
                    } else if (target === 'one' && card.classList.contains('cat-one')) {
                        card.classList.remove('hidden');
                    } else if (target === 'two' && card.classList.contains('cat-two')) {
                        card.classList.remove('hidden');
                    } else if (target === 'three' && card.classList.contains('cat-three')) {
                        card.classList.remove('hidden');
                    } else {
                        card.classList.add('hidden');
                    }
                });
            });
        });
    </script>

</body>
</html>