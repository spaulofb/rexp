<?php
// Define a codificação nos cabeçalhos HTTP do PHP
ini_set('default_charset', 'UTF-8');
header('Content-Type: text/html; charset=UTF-8');
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Corpo Docente - Departamento de Genética FMRP-USP</title>
    <style>
        :root {
            --primary-color: #003366;
            --secondary-color: #0055a5;
            --bg-color: #f4f6f9;
            --card-bg: #ffffff;
            --text-color: #1e293b;
            --border-color: #e2e8f0;
        }

        * { box-sizing: border-box; margin: 0; padding: 0; }

        body {
            font-family: -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, Helvetica, Arial, sans-serif;
            background-color: var(--bg-color);
            color: var(--text-color);
            line-height: 1.6;
            padding-bottom: 50px;
        }

        header {
            background-color: var(--primary-color);
            color: #ffffff;
            padding: 40px 20px;
            text-align: center;
            box-shadow: 0 4px 10px rgba(0,0,0,0.15);
        }

        header h1 { font-size: 2.2rem; margin-bottom: 8px; font-weight: 700; }
        header p { font-size: 1.1rem; opacity: 0.9; }

        .container { max-width: 1200px; margin: 30px auto; padding: 0 20px; }

        .search-bar { margin-bottom: 30px; display: flex; justify-content: center; }

        .search-bar input {
            width: 100%;
            max-width: 600px;
            padding: 14px 20px;
            font-size: 1rem;
            border: 2px solid var(--border-color);
            border-radius: 8px;
            outline: none;
        }

        .grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(350px, 1fr));
            gap: 25px;
        }

        .card {
            background-color: var(--card-bg);
            border-radius: 12px;
            border: 1px solid var(--border-color);
            padding: 25px;
            display: flex;
            flex-direction: column;
            justify-content: space-between;
            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.05);
        }

        .card-header { border-bottom: 2px solid #f1f5f9; padding-bottom: 12px; margin-bottom: 15px; }
        .docente-nome { font-size: 1.3rem; color: var(--primary-color); font-weight: 700; margin-bottom: 4px; }
        .docente-titulacao { font-size: 0.85rem; color: var(--secondary-color); font-weight: 600; text-transform: uppercase; }

        .card-body { flex-grow: 1; }
        .info-label { font-size: 0.8rem; font-weight: 700; color: #64748b; text-transform: uppercase; margin-top: 12px; display: block; }
        .info-content { font-size: 0.95rem; color: #334155; }

        .card-footer { margin-top: 20px; padding-top: 15px; border-top: 1px solid #f1f5f9; }

        .escavador-btn {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            width: 100%;
            padding: 10px 16px;
            background-color: #f8fafc;
            color: var(--secondary-color);
            border: 1.5px solid var(--secondary-color);
            border-radius: 6px;
            text-decoration: none;
            font-weight: 600;
            font-size: 0.9rem;
        }

        .escavador-btn:hover { background-color: var(--secondary-color); color: #ffffff; }

        footer { text-align: center; margin-top: 50px; font-size: 0.85rem; color: #64748b; }
    </style>
</head>
<body>

    <header>
        <h1>Departamento de Genética - FMRP USP</h1>
        <p>Portal Unificado de Docentes e Fontes Públicas (Escavador)</p>
    </header>

    <div class="container">
        <div class="search-bar">
            <input type="text" id="searchInput" placeholder="Buscar por docente, área de pesquisa ou palavra-chave..." onkeyup="filterDocentes()">
        </div>

        <div class="grid" id="docentesGrid">

<?php
$docentes = [
    [
        "nome" => "Alexandro Guterres",
        "titulacao" => "Doutor em Biologia Parasitária (IOC/FIOCRUZ)",
        "area" => "Bioinformática, Genômica de Vírus, Virologia Computacional",
        "resumo" => "Atua no Departamento de Genética da FMRP-USP com foco em análise bioinformática, filogenia e genômica viral.",
        "link" => "https://www.escavador.com/sobre/562520/alexandro-guterres-da-silva"
    ],
    [
        "nome" => "Antônio Rossi Filho",
        "titulacao" => "Professor Titular / Livre-Docente",
        "area" => "Genética de Microorganismos, Bioquímica de Fungos",
        "resumo" => "Especialista em regulação gênica e expressão de fosfatases em fungos filamentosos (Neurospora crassa e Aspergillus nidulans).",
        "link" => "https://www.escavador.com/sobre/5697512/antonio-rossi-filho"
    ],
    [
        "nome" => "Aparecida Maria Fontes",
        "titulacao" => "Doutora em Genética e Biologia Molecular",
        "area" => "Células-Tronco, Terapia Gênica, Cultura de Tecidos",
        "resumo" => "Pesquisa no laboratório de terapia celular e biomedicina do Departamento de Genética da FMRP-USP.",
        "link" => "https://www.escavador.com/busca?qo=t&q=Aparecida+Maria+Fontes"
    ],
    [
        "nome" => "David De Jong",
        "titulacao" => "Professor Titular (PhD em Entomologia)",
        "area" => "Genética de Abelhas, Sanidade Apícola, Acarologia",
        "resumo" => "Pesquisador renomado em genética, seleção e manejo de abelhas africanizadas e controle de parasitas como Varroa destructor.",
        "link" => "https://www.escavador.com/sobre/535230/david-de-jong"
    ],
    [
        "nome" => "Elza Tiemi Sakamoto",
        "titulacao" => "Doutora em Genética",
        "area" => "Citogenética Humana, Mutagênese, Genética Médica",
        "resumo" => "Atua em citogenética clínica, diagnóstico cromossômico e alterações genéticas no desenvolvimento humano.",
        "link" => "https://www.escavador.com/busca?go=t&q=Elza+Tiemi+Sakamoto"
    ],
    [
        "nome" => "Ester Silveira Ramos",
        "titulacao" => "Professora Titular / Livre-Docente",
        "area" => "Genética Humana, Diferenciação Sexual, Epigenética",
        "resumo" => "Especialista em anomalias do desenvolvimento sexual, aconselhamento genético e marcadores epigenéticos em saúde.",
        "link" => "https://www.escavador.com/sobre/1315014/ester-silveira-ramos"
    ],
    [
        "nome" => "Geraldo Aleixo Da Silva Passos Junior",
        "titulacao" => "Professor Titular / Livre-Docente",
        "area" => "Imunogenômica, Transcriptômica, Bioinformática",
        "resumo" => "Lidera pesquisas no Laboratório de Imunogenética Molecular (FMRP-USP) focando na regulação da expressão gênica no timo e tolerância imunológica.",
        "link" => "https://www.escavador.com/busca?qo=t&q=Geraldo+Aleixo+Da+Silva+Passos+Junior"
    ],
    [
        "nome" => "Israel Gomy",
        "titulacao" => "Doutor em Genética / Médico Geneticista",
        "area" => "Genética Clínica, Oncogenética, Neoplasias Hereditárias",
        "resumo" => "Atua na investigação médica e molecular de síndromes de predisposição hereditária ao câncer e oncogenética clínica.",
        "link" => "https://www.escavador.com/sobre/588978/israel-gomy"
    ],
    [
        "nome" => "Jeremy Andrew Squire",
        "titulacao" => "Professor Visitante / Titular (PhD)",
        "area" => "Citogenômica do Câncer, Biologia Molecular de Tumores",
        "resumo" => "Pesquisador internacional com foco em alterações cromossômicas, biomarcadores genômicos e instabilidade genômica em cânceres humanos.",
        "link" => "https://www.escavador.com/sobre/599848/jeremy-andrew-squire"
    ],
    [
        "nome" => "Klaus Hartmann Hartfelder",
        "titulacao" => "Professor Titular (Dr. rer. nat.)",
        "area" => "Genética do Desenvolvimento de Insetos, Sociobiontes, Evo-Devo",
        "resumo" => "Especialista na regulação hormonal e epigenética do desenvolvimento de castas e diferenciação em abelhas (Apis mellifera).",
        "link" => "https://www.escavador.com/sobre/526024/klaus-hartmann-hartfelder"
    ],
    [
        "nome" => "Marina Candido Visontai Cormedi Lemos",
        "titulacao" => "Doutora em Ciências",
        "area" => "Genética Humana e Médica, Biologia Molecular",
        "resumo" => "Pesquisadora dedicada ao estudo de variantes genéticas e diagnósticos moleculares no contexto da Genética Médica da FMRP-USP.",
        "link" => "https://www.escavador.com/sobre/7368938/marina-candido-visontai-cormedi"
    ],
    [
        "nome" => "Nilce Maria Martinez Rossi",
        "titulacao" => "Professora Titular / Livre-Docente",
        "area" => "Genética Molecular de Fungos, Dermatófitos, Fatores de Virulência",
        "resumo" => "Estuda os mecanismos moleculares de resistência a antifúngicos e fatores de virulência em fungos patogênicos humanos.",
        "link" => "https://www.escavador.com/sobre/8951971/nilce-maria-martinez-rossi"
    ],
    [
        "nome" => "Silvana Giuliatti",
        "titulacao" => "Professora Associada / Livre-Docente",
        "area" => "Bioinformática, Modelagem de Proteínas, Genômica Estrutural",
        "resumo" => "Coordenadora de projetos de bioinformática estrutural, análise de variantes de nucleotídeo único (SNPs) e simulação molecular.",
        "link" => "https://www.escavador.com/sobre/7309563/silvana-giuliatti"
    ],
    [
        "nome" => "Thiago Yukio Kikuchi Oliveira",
        "titulacao" => "Doutor em Biologia Computacional",
        "area" => "Bioinformática, Imunoinformática, Sequenciamento de Nova Geração (NGS)",
        "resumo" => "Especialista em pipelines de análise de sequenciamento de alto desempenho, imunogenômica e desenvolvimento de software científico.",
        "link" => "https://www.escavador.com/sobre/596892/thiago-yukio-kikuchi-oliveira"
    ],
    [
        "nome" => "Victor Evangelista De Faria Ferraz",
        "titulacao" => "Professor Doutor / Médico Geneticista",
        "area" => "Genética Clínica, Erros Inatos do Metabolismo, Anomalias Congênitas",
        "resumo" => "Atua no atendimento clínico e pesquisa em genética médica, diagnóstico de doenças raras e dismorfologia no Hospital das Clínicas da FMRP-USP.",
        "link" => "https://www.escavador.com/sobre/1314973/victor-evangelista-de-faria-ferraz"
    ],
    [
        "nome" => "Wilson Araújo Da Silva Junior",
        "titulacao" => "Professor Titular / Livre-Docente",
        "area" => "Genômica de Câncer, Terapia Celular, Bioinformática Clínica",
        "resumo" => "Lidera pesquisas em sequenciamento genômico em larga escala, redes de interação de microARNs e desenvolvimento de alvos terapêuticos em oncologia.",
        "link" => "https://www.escavador.com/sobre/1301441/wilson-araujo-da-silva-junior"
    ]
];

foreach ($docentes as $doc) {
    // Converte os textos para UTF-8 limpo caso o servidor interprete como ISO
    $nome = htmlspecialchars($doc['nome'], ENT_QUOTES, 'UTF-8');
    $titulacao = htmlspecialchars($doc['titulacao'], ENT_QUOTES, 'UTF-8');
    $area = htmlspecialchars($doc['area'], ENT_QUOTES, 'UTF-8');
    $resumo = htmlspecialchars($doc['resumo'], ENT_QUOTES, 'UTF-8');
    $link = $doc['link'];

    echo "
    <div class=\"card\" data-search=\"".mb_strtolower($nome.' '.$area.' '.$titulacao, 'UTF-8')."\">
        <div>
            <div class=\"card-header\">
                <div class=\"docente-nome\">{$nome}</div>
                <div class=\"docente-titulacao\">{$titulacao}</div>
            </div>
            <div class=\"card-body\">
                <span class=\"info-label\">Área de Atuação / Especialidade</span>
                <div class=\"info-content\">{$area}</div>
                
                <span class=\"info-label\">Resumo do Perfil</span>
                <div class=\"info-content\">{$resumo}</div>
            </div>
        </div>
        <div class=\"card-footer\">
            <a href=\"{$link}\" target=\"_blank\" rel=\"noopener noreferrer\" class=\"escavador-btn\">
                Ver no Escavador &rarr;
            </a>
        </div>
    </div>\n";
}
?>

        </div>
    </div>

    <footer>
        <p>Desenvolvido para consulta interna e integração de dados institucionais • FMRP-USP 2026</p>
    </footer>

    <script>
        function filterDocentes() {
            const input = document.getElementById('searchInput').value.toLowerCase();
            const cards = document.querySelectorAll('.card');

            cards.forEach(card => {
                const searchData = card.getAttribute('data-search');
                if (searchData.includes(input)) {
                    card.style.display = 'flex';
                } else {
                    card.style.display = 'none';
                }
            });
        }
    </script>
</body>
</html>  



