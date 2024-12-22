<?php
    $clanky = [
        ["nazev" => "Budoucnost nanotechnologií", "kategorie" => "Technologie"],
        ["nazev" => "Zdravý životní styl a jeho přínosy", "kategorie" => "Zdraví"],
        ["nazev" => "Umělá inteligence v každodenním životě", "kategorie" => "Technologie"],
        ["nazev" => "Trendy v moderní výživě", "kategorie" => "Zdraví"],
        ["nazev" => "Ekologické bydlení a jeho výhody", "kategorie" => "Životní styl"]
    ];
    
    $kategorie = ["Technologie", "Zdraví", "Životní styl"];

    $vybranaKategorie = isset($_GET['kategorie']) ? $_GET['kategorie'] : '';
?>

<!DOCTYPE html>
<html lang="cs">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Filtrované články</title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body>

    <main>
        <section class="form-content" id="form-content">
            <div class="container">
                <form method="GET" action="">
                    <label for="kategorie">Vyberte kategorii:</label>
                    <select id="kategorie" name="kategorie">
                        <option value="">Všechny kategorie</option>
                        <?php foreach ($kategorie as $kategorieItem): ?>
                            <option value="<?php echo $kategorieItem; ?>" <?php echo $vybranaKategorie == $kategorieItem ? 'selected' : ''; ?>>
                                <?php echo $kategorieItem; ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                    <button type="submit">Filtrovat</button>
                </form>
            </div>
        </section>

        <section class="articles">
            <div class="container">
                <h2>Články</h2>
                <ul>
                    <?php
                    foreach ($clanky as $clanek) 
                    {
                        if ($vybranaKategorie == '' || $clanek['kategorie'] == $vybranaKategorie) 
                        {
                            echo "<li>{$clanek['nazev']}</li>";
                        }
                    }
                    ?>
                </ul>
            </div>
        </section>
    </main>

</body>
</html>
