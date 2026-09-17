<?php
//
//  Corrigir acentuaÃ§Ã£o
header('Content-Type: text/html; charset=utf-8');
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Corpo Docente - Departamento de GenÃÂ©tica FMRP-USP</title>
    <style>
        :root {
            --primary-color: #003366;
            --secondary-color: #0055a5;
            --accent-color: #d97706;
            --bg-color: #f4f6f9;
            --card-bg: #ffffff;
            --text-color: #1e293b;
            --border-color: #e2e8f0;
        }

        * {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
        }

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

        header h1 {
            font-size: 2.2rem;
            margin-bottom: 8px;
            font-weight: 700;
        }

        header p {
            font-size: 1.1rem;
            opacity: 0.9;
        }

        .container {
            max-width: 1200px;
            margin: 30px auto;
            padding: 0 20px;
        }

        .search-bar {
            margin-bottom: 30px;
            display: flex;
            justify-content: center;
        }

        .search-bar input {
            width: 100%;
            max-width: 600px;
            padding: 14px 20px;
            font-size: 1rem;
            border: 2px solid var(--border-color);
            border-radius: 8px;
            outline: none;
            transition: border-color 0.3s;
        }

        .search-bar input:focus {
            border-color: var(--secondary-color);
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
            transition: transform 0.2s, box-shadow 0.2s;
        }

        .card:hover {
            transform: translateY(-4px);
            box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.1);
        }

        .card-header {
            border-bottom: 2px solid #f1f5f9;
            padding-bottom: 12px;
            margin-bottom: 15px;
        }

        .docente-nome {
            font-size: 1.3rem;
            color: var(--primary-color);
            font-weight: 700;
            margin-bottom: 4px;
        }

        .docente-titulacao {
            font-size: 0.85rem;
            color: var(--secondary-color);
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        .card-body {
            flex-grow: 1;
        }

        .info-label {
            font-size: 0.8rem;
            font-weight: 700;
            color: #64748b;
            text-transform: uppercase;
            margin-top: 12px;
            display: block;
        }

        .info-content {
            font-size: 0.95rem;
            color: #334155;
        }

        .card-footer {
            margin-top: 20px;
            padding-top: 15px;
            border-top: 1px solid #f1f5f9;
        }

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
            transition: all 0.2s;
        }

        .escavador-btn:hover {
            background-color: var(--secondary-color);
            color: #ffffff;
        }

        footer {
            text-align: center;
            margin-top: 50px;
            font-size: 0.85rem;
            color: #64748b;
        }
    </style>
</head>
<body>

    <header>
        <h1>Departamento de GenÃÂ©tica - FMRP USP</h1>
        <p>Portal Unificado de Docentes e Fontes PÃÂºblicas (Escavador)</p>
    </header>

    <div class="container">
        <div class="search-bar">
            <input type="text" id="searchInput" placeholder="Buscar por docente, ÃÂ¡rea de pesquisa ou palavra-chave..." onkeyup="filterDocentes()">
        </div>

        <div class="grid" id="docentesGrid">

            <div class="card" data-search="alexandro guterres bioinformÃÂ¡tica, genÃÂ´mica de vÃÂ­rus, virologia computacional doutor em biologia parasitÃÂ¡ria (ioc/fiocruz)">
                <div>
                    <div class="card-header">
                        <div class="docente-nome">Alexandro Guterres</div>
                        <div class="docente-titulacao">Doutor em Biologia ParasitÃÂ¡ria (IOC/FIOCRUZ)</div>
                    </div>
                    <div class="card-body">
                        <span class="info-label">Ã?rea de AtuaÃÂ§ÃÂ£o / Especialidade</span>
                        <div class="info-content">BioinformÃÂ¡tica, GenÃÂ´mica de VÃÂ­rus, Virologia Computacional</div>
                        
                        <span class="info-label">Resumo do Perfil</span>
                        <div class="info-content">Atua no Departamento de GenÃÂ©tica da FMRP-USP com foco em anÃÂ¡lise bioinformÃÂ¡tica, filogenia e genÃÂ´mica viral.</div>
                    </div>
                </div>
                <div class="card-footer">
                    <a href="https://www.escavador.com/sobre/562520/alexandro-guterres-da-silva" target="_blank" rel="noopener noreferrer" class="escavador-btn">
                        Ver no Escavador Ã¢Å¾â
                    </a>
                </div>
            </div>
    
            <div class="card" data-search="antÃÂ´nio rossi filho genÃÂ©tica de microorganismos, bioquÃÂ­mica de fungos professor titular / livre-docente">
                <div>
                    <div class="card-header">
                        <div class="docente-nome">AntÃÂ´nio Rossi Filho</div>
                        <div class="docente-titulacao">Professor Titular / Livre-Docente</div>
                    </div>
                    <div class="card-body">
                        <span class="info-label">Ã?rea de AtuaÃÂ§ÃÂ£o / Especialidade</span>
                        <div class="info-content">GenÃÂ©tica de Microorganismos, BioquÃÂ­mica de Fungos</div>
                        
                        <span class="info-label">Resumo do Perfil</span>
                        <div class="info-content">Especialista em regulaÃÂ§ÃÂ£o gÃÂªnica e expressÃÂ£o de fosfatases em fungos filamentosos (Neurospora crassa e Aspergillus nidulans).</div>
                    </div>
                </div>
                <div class="card-footer">
                    <a href="https://www.escavador.com/sobre/5697512/antonio-rossi-filho" target="_blank" rel="noopener noreferrer" class="escavador-btn">
                        Ver no Escavador Ã¢Å¾â
                    </a>
                </div>
            </div>
    
            <div class="card" data-search="aparecida maria fontes cÃÂ©lulas-tronco, terapia gÃÂªnica, cultura de tecidos doutora em genÃÂ©tica e biologia molecular">
                <div>
                    <div class="card-header">
                        <div class="docente-nome">Aparecida Maria Fontes</div>
                        <div class="docente-titulacao">Doutora em GenÃÂ©tica e Biologia Molecular</div>
                    </div>
                    <div class="card-body">
                        <span class="info-label">Ã?rea de AtuaÃÂ§ÃÂ£o / Especialidade</span>
                        <div class="info-content">CÃÂ©lulas-Tronco, Terapia GÃÂªnica, Cultura de Tecidos</div>
                        
                        <span class="info-label">Resumo do Perfil</span>
                        <div class="info-content">Pesquisa no laboratÃÂ³rio de terapia celular e biomedicina do Departamento de GenÃÂ©tica da FMRP-USP.</div>
                    </div>
                </div>
                <div class="card-footer">
                    <a href="https://www.escavador.com/busca?qo=t&q=Aparecida+Maria+Fontes" target="_blank" rel="noopener noreferrer" class="escavador-btn">
                        Ver no Escavador Ã¢Å¾â
                    </a>
                </div>
            </div>
    
            <div class="card" data-search="david de jong genÃÂ©tica de abelhas, sanidade apÃÂ­cola, acarologia professor titular (phd em entomologia)">
                <div>
                    <div class="card-header">
                        <div class="docente-nome">David De Jong</div>
                        <div class="docente-titulacao">Professor Titular (PhD em Entomologia)</div>
                    </div>
                    <div class="card-body">
                        <span class="info-label">Ã?rea de AtuaÃÂ§ÃÂ£o / Especialidade</span>
                        <div class="info-content">GenÃÂ©tica de Abelhas, Sanidade ApÃÂ­cola, Acarologia</div>
                        
                        <span class="info-label">Resumo do Perfil</span>
                        <div class="info-content">Pesquisador renomado em genÃÂ©tica, seleÃÂ§ÃÂ£o e manejo de abelhas africanizadas e controle de parasitas como Varroa destructor.</div>
                    </div>
                </div>
                <div class="card-footer">
                    <a href="https://www.escavador.com/sobre/535230/david-de-jong" target="_blank" rel="noopener noreferrer" class="escavador-btn">
                        Ver no Escavador Ã¢Å¾â
                    </a>
                </div>
            </div>
    
            <div class="card" data-search="elza tiemi sakamoto citogenÃÂ©tica humana, mutagÃÂªnese, genÃÂ©tica mÃÂ©dica doutora em genÃÂ©tica">
                <div>
                    <div class="card-header">
                        <div class="docente-nome">Elza Tiemi Sakamoto</div>
                        <div class="docente-titulacao">Doutora em GenÃÂ©tica</div>
                    </div>
                    <div class="card-body">
                        <span class="info-label">Ã?rea de AtuaÃÂ§ÃÂ£o / Especialidade</span>
                        <div class="info-content">CitogenÃÂ©tica Humana, MutagÃÂªnese, GenÃÂ©tica MÃÂ©dica</div>
                        
                        <span class="info-label">Resumo do Perfil</span>
                        <div class="info-content">Atua em citogenÃÂ©tica clÃÂ­nica, diagnÃÂ³stico cromossÃÂ´mico e alteraÃÂ§ÃÂµes genÃÂ©ticas no desenvolvimento humano.</div>
                    </div>
                </div>
                <div class="card-footer">
                    <a href="https://www.escavador.com/busca?go=t&q=Elza+Tiemi+Sakamoto" target="_blank" rel="noopener noreferrer" class="escavador-btn">
                        Ver no Escavador Ã¢Å¾â
                    </a>
                </div>
            </div>
    
            <div class="card" data-search="ester silveira ramos genÃÂ©tica humana, diferenciaÃÂ§ÃÂ£o sexual, epigenÃÂ©tica professora titular / livre-docente">
                <div>
                    <div class="card-header">
                        <div class="docente-nome">Ester Silveira Ramos</div>
                        <div class="docente-titulacao">Professora Titular / Livre-Docente</div>
                    </div>
                    <div class="card-body">
                        <span class="info-label">Ã?rea de AtuaÃÂ§ÃÂ£o / Especialidade</span>
                        <div class="info-content">GenÃÂ©tica Humana, DiferenciaÃÂ§ÃÂ£o Sexual, EpigenÃÂ©tica</div>
                        
                        <span class="info-label">Resumo do Perfil</span>
                        <div class="info-content">Especialista em anomalias do desenvolvimento sexual, aconselhamento genÃÂ©tico e marcadores epigenÃÂ©ticos em saÃÂºde.</div>
                    </div>
                </div>
                <div class="card-footer">
                    <a href="https://www.escavador.com/sobre/1315014/ester-silveira-ramos" target="_blank" rel="noopener noreferrer" class="escavador-btn">
                        Ver no Escavador Ã¢Å¾â
                    </a>
                </div>
            </div>
    
            <div class="card" data-search="geraldo aleixo da silva passos junior imunogenÃÂ´mica, transcriptÃÂ´mica, bioinformÃÂ¡tica professor titular / livre-docente">
                <div>
                    <div class="card-header">
                        <div class="docente-nome">Geraldo Aleixo Da Silva Passos Junior</div>
                        <div class="docente-titulacao">Professor Titular / Livre-Docente</div>
                    </div>
                    <div class="card-body">
                        <span class="info-label">Ã?rea de AtuaÃÂ§ÃÂ£o / Especialidade</span>
                        <div class="info-content">ImunogenÃÂ´mica, TranscriptÃÂ´mica, BioinformÃÂ¡tica</div>
                        
                        <span class="info-label">Resumo do Perfil</span>
                        <div class="info-content">Lidera pesquisas no LaboratÃÂ³rio de ImunogenÃÂ©tica Molecular (FMRP-USP) focando na regulaÃÂ§ÃÂ£o da expressÃÂ£o gÃÂªnica no timo e tolerÃÂ¢ncia imunolÃÂ³gica.</div>
                    </div>
                </div>
                <div class="card-footer">
                    <a href="https://www.escavador.com/busca?qo=t&q=Geraldo+Aleixo+Da+Silva+Passos+Junior" target="_blank" rel="noopener noreferrer" class="escavador-btn">
                        Ver no Escavador Ã¢Å¾â
                    </a>
                </div>
            </div>
    
            <div class="card" data-search="israel gomy genÃÂ©tica clÃÂ­nica, oncogenÃÂ©tica, neoplasias hereditÃÂ¡rias doutor em genÃÂ©tica / mÃÂ©dico geneticista">
                <div>
                    <div class="card-header">
                        <div class="docente-nome">Israel Gomy</div>
                        <div class="docente-titulacao">Doutor em GenÃÂ©tica / MÃÂ©dico Geneticista</div>
                    </div>
                    <div class="card-body">
                        <span class="info-label">Ã?rea de AtuaÃÂ§ÃÂ£o / Especialidade</span>
                        <div class="info-content">GenÃÂ©tica ClÃÂ­nica, OncogenÃÂ©tica, Neoplasias HereditÃÂ¡rias</div>
                        
                        <span class="info-label">Resumo do Perfil</span>
                        <div class="info-content">Atua na investigaÃÂ§ÃÂ£o mÃÂ©dica e molecular de sÃÂ­ndromes de predisposiÃÂ§ÃÂ£o hereditÃÂ¡ria ao cÃÂ¢ncer e oncogenÃÂ©tica clÃÂ­nica.</div>
                    </div>
                </div>
                <div class="card-footer">
                    <a href="https://www.escavador.com/sobre/588978/israel-gomy" target="_blank" rel="noopener noreferrer" class="escavador-btn">
                        Ver no Escavador Ã¢Å¾â
                    </a>
                </div>
            </div>
    
            <div class="card" data-search="jeremy andrew squire citogenÃÂ´mica do cÃÂ¢ncer, biologia molecular de tumores professor visitante / titular (phd)">
                <div>
                    <div class="card-header">
                        <div class="docente-nome">Jeremy Andrew Squire</div>
                        <div class="docente-titulacao">Professor Visitante / Titular (PhD)</div>
                    </div>
                    <div class="card-body">
                        <span class="info-label">Ã?rea de AtuaÃÂ§ÃÂ£o / Especialidade</span>
                        <div class="info-content">CitogenÃÂ´mica do CÃÂ¢ncer, Biologia Molecular de Tumores</div>
                        
                        <span class="info-label">Resumo do Perfil</span>
                        <div class="info-content">Pesquisador internacional com foco em alteraÃÂ§ÃÂµes cromossÃÂ´micas, biomarcadores genÃÂ´micos e instabilidade genÃÂ´mica em cÃÂ¢nceres humanos.</div>
                    </div>
                </div>
                <div class="card-footer">
                    <a href="https://www.escavador.com/sobre/599848/jeremy-andrew-squire" target="_blank" rel="noopener noreferrer" class="escavador-btn">
                        Ver no Escavador Ã¢Å¾â
                    </a>
                </div>
            </div>
    
            <div class="card" data-search="klaus hartmann hartfelder genÃÂ©tica do desenvolvimento de insetos, sociobiontes, evo-devo professor titular (dr. rer. nat.)">
                <div>
                    <div class="card-header">
                        <div class="docente-nome">Klaus Hartmann Hartfelder</div>
                        <div class="docente-titulacao">Professor Titular (Dr. rer. nat.)</div>
                    </div>
                    <div class="card-body">
                        <span class="info-label">Ã?rea de AtuaÃÂ§ÃÂ£o / Especialidade</span>
                        <div class="info-content">GenÃÂ©tica do Desenvolvimento de Insetos, Sociobiontes, Evo-Devo</div>
                        
                        <span class="info-label">Resumo do Perfil</span>
                        <div class="info-content">Especialista na regulaÃÂ§ÃÂ£o hormonal e epigenÃÂ©tica do desenvolvimento de castas e diferenciaÃÂ§ÃÂ£o em abelhas (Apis mellifera).</div>
                    </div>
                </div>
                <div class="card-footer">
                    <a href="https://www.escavador.com/sobre/526024/klaus-hartmann-hartfelder" target="_blank" rel="noopener noreferrer" class="escavador-btn">
                        Ver no Escavador Ã¢Å¾â
                    </a>
                </div>
            </div>
    
            <div class="card" data-search="marina candido visontai cormedi lemos genÃÂ©tica humana e mÃÂ©dica, biologia molecular doutora em ciÃÂªncias">
                <div>
                    <div class="card-header">
                        <div class="docente-nome">Marina Candido Visontai Cormedi Lemos</div>
                        <div class="docente-titulacao">Doutora em CiÃÂªncias</div>
                    </div>
                    <div class="card-body">
                        <span class="info-label">Ã?rea de AtuaÃÂ§ÃÂ£o / Especialidade</span>
                        <div class="info-content">GenÃÂ©tica Humana e MÃÂ©dica, Biologia Molecular</div>
                        
                        <span class="info-label">Resumo do Perfil</span>
                        <div class="info-content">Pesquisadora dedicada ao estudo de variantes genÃÂ©ticas e diagnÃÂ³sticos moleculares no contexto da GenÃÂ©tica MÃÂ©dica da FMRP-USP.</div>
                    </div>
                </div>
                <div class="card-footer">
                    <a href="https://www.escavador.com/sobre/7368938/marina-candido-visontai-cormedi" target="_blank" rel="noopener noreferrer" class="escavador-btn">
                        Ver no Escavador Ã¢Å¾â
                    </a>
                </div>
            </div>
    
            <div class="card" data-search="nilce maria martinez rossi genÃÂ©tica molecular de fungos, dermatÃÂ³fitos, fatores de virulÃÂªncia professora titular / livre-docente">
                <div>
                    <div class="card-header">
                        <div class="docente-nome">Nilce Maria Martinez Rossi</div>
                        <div class="docente-titulacao">Professora Titular / Livre-Docente</div>
                    </div>
                    <div class="card-body">
                        <span class="info-label">Ã?rea de AtuaÃÂ§ÃÂ£o / Especialidade</span>
                        <div class="info-content">GenÃÂ©tica Molecular de Fungos, DermatÃÂ³fitos, Fatores de VirulÃÂªncia</div>
                        
                        <span class="info-label">Resumo do Perfil</span>
                        <div class="info-content">Estuda os mecanismos moleculares de resistÃÂªncia a antifÃÂºngicos e fatores de virulÃÂªncia em fungos patogÃÂªnicos humanos.</div>
                    </div>
                </div>
                <div class="card-footer">
                    <a href="https://www.escavador.com/sobre/8951971/nilce-maria-martinez-rossi" target="_blank" rel="noopener noreferrer" class="escavador-btn">
                        Ver no Escavador Ã¢Å¾â
                    </a>
                </div>
            </div>
    
            <div class="card" data-search="silvana giuliatti bioinformÃÂ¡tica, modelagem de proteÃÂ­nas, genÃÂ´mica estrutural professora associada / livre-docente">
                <div>
                    <div class="card-header">
                        <div class="docente-nome">Silvana Giuliatti</div>
                        <div class="docente-titulacao">Professora Associada / Livre-Docente</div>
                    </div>
                    <div class="card-body">
                        <span class="info-label">Ã?rea de AtuaÃÂ§ÃÂ£o / Especialidade</span>
                        <div class="info-content">BioinformÃÂ¡tica, Modelagem de ProteÃÂ­nas, GenÃÂ´mica Estrutural</div>
                        
                        <span class="info-label">Resumo do Perfil</span>
                        <div class="info-content">Coordenadora de projetos de bioinformÃÂ¡tica estrutural, anÃÂ¡lise de variantes de nucleotÃÂ­deo ÃÂºnico (SNPs) e simulaÃÂ§ÃÂ£o molecular.</div>
                    </div>
                </div>
                <div class="card-footer">
                    <a href="https://www.escavador.com/sobre/7309563/silvana-giuliatti" target="_blank" rel="noopener noreferrer" class="escavador-btn">
                        Ver no Escavador Ã¢Å¾â
                    </a>
                </div>
            </div>
    
            <div class="card" data-search="thiago yukio kikuchi oliveira bioinformÃÂ¡tica, imunoinformÃÂ¡tica, sequenciamento de nova geraÃÂ§ÃÂ£o (ngs) doutor em biologia computacional">
                <div>
                    <div class="card-header">
                        <div class="docente-nome">Thiago Yukio Kikuchi Oliveira</div>
                        <div class="docente-titulacao">Doutor em Biologia Computacional</div>
                    </div>
                    <div class="card-body">
                        <span class="info-label">Ã?rea de AtuaÃÂ§ÃÂ£o / Especialidade</span>
                        <div class="info-content">BioinformÃÂ¡tica, ImunoinformÃÂ¡tica, Sequenciamento de Nova GeraÃÂ§ÃÂ£o (NGS)</div>
                        
                        <span class="info-label">Resumo do Perfil</span>
                        <div class="info-content">Especialista em pipelines de anÃÂ¡lise de sequenciamento de alto desempenho, imunogenÃÂ´mica e desenvolvimento de software cientÃÂ­fico.</div>
                    </div>
                </div>
                <div class="card-footer">
                    <a href="https://www.escavador.com/sobre/596892/thiago-yukio-kikuchi-oliveira" target="_blank" rel="noopener noreferrer" class="escavador-btn">
                        Ver no Escavador Ã¢Å¾â
                    </a>
                </div>
            </div>
    
            <div class="card" data-search="victor evangelista de faria ferraz genÃÂ©tica clÃÂ­nica, erros inatos do metabolismo, anomalias congÃÂªnitas professor doutor / mÃÂ©dico geneticista">
                <div>
                    <div class="card-header">
                        <div class="docente-nome">Victor Evangelista De Faria Ferraz</div>
                        <div class="docente-titulacao">Professor Doutor / MÃÂ©dico Geneticista</div>
                    </div>
                    <div class="card-body">
                        <span class="info-label">Ã?rea de AtuaÃÂ§ÃÂ£o / Especialidade</span>
                        <div class="info-content">GenÃÂ©tica ClÃÂ­nica, Erros Inatos do Metabolismo, Anomalias CongÃÂªnitas</div>
                        
                        <span class="info-label">Resumo do Perfil</span>
                        <div class="info-content">Atua no atendimento clÃÂ­nico e pesquisa em genÃÂ©tica mÃÂ©dica, diagnÃÂ³stico de doenÃÂ§as raras e dismorfologia no Hospital das ClÃÂ­nicas da FMRP-USP.</div>
                    </div>
                </div>
                <div class="card-footer">
                    <a href="https://www.escavador.com/sobre/1314973/victor-evangelista-de-faria-ferraz" target="_blank" rel="noopener noreferrer" class="escavador-btn">
                        Ver no Escavador Ã¢Å¾â
                    </a>
                </div>
            </div>
    
            <div class="card" data-search="wilson araÃÂºjo da silva junior genÃÂ´mica de cÃÂ¢ncer, terapia celular, bioinformÃÂ¡tica clÃÂ­nica professor titular / livre-docente">
                <div>
                    <div class="card-header">
                        <div class="docente-nome">Wilson AraÃÂºjo Da Silva Junior</div>
                        <div class="docente-titulacao">Professor Titular / Livre-Docente</div>
                    </div>
                    <div class="card-body">
                        <span class="info-label">Ã?rea de AtuaÃÂ§ÃÂ£o / Especialidade</span>
                        <div class="info-content">GenÃÂ´mica de CÃÂ¢ncer, Terapia Celular, BioinformÃÂ¡tica ClÃÂ­nica</div>
                        
                        <span class="info-label">Resumo do Perfil</span>
                        <div class="info-content">Lidera pesquisas em sequenciamento genÃÂ´mico em larga escala, redes de interaÃÂ§ÃÂ£o de microARNs e desenvolvimento de alvos terapÃÂªuticos em oncologia.</div>
                    </div>
                </div>
                <div class="card-footer">
                    <a href="https://www.escavador.com/sobre/1301441/wilson-araujo-da-silva-junior" target="_blank" rel="noopener noreferrer" class="escavador-btn">
                        Ver no Escavador Ã¢Å¾â
                    </a>
                </div>
            </div>
    
        </div>
    </div>

    <footer>
        <p>Desenvolvido para consulta interna e integraÃÂ§ÃÂ£o de dados institucionais Ã¢â¬Â¢ FMRP-USP 2026</p>
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
 

