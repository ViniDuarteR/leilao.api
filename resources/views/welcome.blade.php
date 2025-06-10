<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Fernanda Freire - Leiloeira Oficial</title>

    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
    
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;700&display=swap" rel="stylesheet">
</head>
<body>

    <header class="header-container">
        <div class="logo-container">
            <img src="{{ asset('images/logo_fernarda-freire.png') }}" alt="Logo Fernanda Freire Leilões">
            <div class="logo-text">
                <span>LEILOEIRA OFICIAL - JUCERJA 276</span>
                <strong>FERNANDA FREIRE</strong>
            </div>
        </div>

        <nav>
            <ul>
                <li><a href="#">Home</a></li>
                <li><a href="#">Sobre a Leiloeira</a></li>
                <li><a href="#">Leilões</a></li>
            </ul>
        </nav>

        <div class="header-contato">

            <a href="#" id="btn-toggle-busca" class="btn-busca">BUSCA AVANÇADA ▼</a>

            <section class="busca-container hidden">
                <h3>Busca Avançada</h3>
                <div class="filtros-wrapper">
                    <div class="filtro-item">
                        <label for="filtro-localizacao">Localização</label>
                        <input type="text" id="filtro-localizacao" placeholder="Cidade ou bairro...">
                    </div>
                    <div class="filtro-item">
                        <label for="filtro-preco-min">Preço Mínimo</label>
                        <input type="number" id="filtro-preco-min" placeholder="R$ 10.000">
                    </div>
                    <div class="filtro-item">
                        <label for="filtro-preco-max">Preço Máximo</label>
                        <input type="number" id="filtro-preco-max" placeholder="R$ 500.000">
                    </div>
                    <div class="filtro-item">
                        <button id="btn-filtrar">Filtrar Leilões</button>
                    </div>
                </div>
            </section>
        </div>
    </header>

    <section class="banner-hero">
        <img src="{{ asset('images/bannerFernanda.png') }}" alt="Banner Principal - Leilões Fernanda Freire">
    </section>

    <main>
        <h2>Leilões em Destaque</h2>

        <div id="leiloes-grid" class="grid-container"></div>

        <div class="veja-mais-container">
            <a href="#" class="btn-veja-mais">VEJA MAIS LEILÕES</a>
        </div>
    </main>

<footer>
    <div class="footer-content">
        <div class="footer-column">
            <h4>Contato</h4>
            <p>Rua Doutor Sardinha, 140 - Apto. 510<br>Santa Rosa, Niterói/Rio de Janeiro<br>CEP: 24240-660</p>
            <p><strong>Email:</strong> fernandafreireleiloes@gmail.com</p>
            <p><strong>Telefone:</strong> +55 (21) 99455-3955</p>
        </div>

        <div class="footer-column">
            <h4>Links Rápidos</h4>
            <ul>
                <li><a href="#">Home</a></li>
                <li><a href="#">Sobre a Leiloeira</a></li>
                <li><a href="#">Leilões</a></li>
            </ul>
        </div>
    </div>
    <div class="footer-bottom">
        <p>&copy; {{ date('Y') }} Fernanda Freire Leilões. Todos os direitos reservados.</p>
    </div>
</footer>

<script>
    // Espera todo o conteúdo HTML da página ser carregado antes de executar o script
document.addEventListener('DOMContentLoaded', () => {

    // --- Bloco 1: Seleção dos Elementos do HTML (DOM) ---
    const leiloesGrid = document.getElementById('leiloes-grid');
    const btnFiltrar = document.getElementById('btn-filtrar');
    const inputLocalizacao = document.getElementById('filtro-localizacao');
    const inputPrecoMin = document.getElementById('filtro-preco-min');
    const inputPrecoMax = document.getElementById('filtro-preco-max');
    const btnToggleBusca = document.getElementById('btn-toggle-busca');
    const buscaContainer = document.querySelector('.busca-container');

    // --- Bloco 2: Funções Auxiliares ---
    const formatarMoeda = (valor) => {
        const numero = parseFloat(valor);
        return new Intl.NumberFormat('pt-BR', {
            style: 'currency',
            currency: 'BRL'
        }).format(numero);
    };

    // --- Bloco 3: Função Principal de Carga dos Leilões ---
    async function carregarLeiloes(filtros = {}) {
        const queryParams = new URLSearchParams(filtros).toString();
        leiloesGrid.innerHTML = '<p>Carregando leilões...</p>';

        try {
            const response = await fetch(`/api/leiloes?${queryParams}`);
            const leiloes = await response.json();

            if (!leiloes || leiloes.length === 0) {
                leiloesGrid.innerHTML = '<p>Nenhum leilão encontrado para os filtros selecionados.</p>';
                return;
            }

            leiloesGrid.innerHTML = '';
            leiloes.forEach(leilao => {
                // Garantimos que o data-leilao-id seja adicionado ao botão
                const cardHtml = `
                    <div class="card-leilao">
                        <img src="${leilao.url_imagem}" alt="${leilao.titulo}">
                        <div class="info">
                            <h3>${leilao.titulo}</h3>
                            <p class="endereco">${leilao.endereco}</p>
                            <p class="matricula">Matrícula: ${leilao.matricula}</p>
                            <p class="view-count">👁️ ${leilao.view_count} visualizações</p> {{-- LINHA NOVA --}}
                            <div class="preco">
                                <p class="avaliacao">Avaliação: ${formatarMoeda(leilao.valor_avaliacao)}</p>
                                <p class="preco-atual">Preço atual: ${formatarMoeda(leilao.preco_atual)}</p>
                            </div>
                        </div>
                        <a href="${leilao.url_anuncio}" class="ver-anuncio-btn" data-leilao-id="${leilao.id}">VER ANÚNCIO</a>
                    </div>
                `;
                leiloesGrid.innerHTML += cardHtml;
            });
        } catch (error) {
            console.error('Erro ao carregar leilões:', error);
            leiloesGrid.innerHTML = '<p>Ocorreu um erro ao carregar os leilões.</p>';
        }
    }

    // --- Bloco 4: Lógica dos Eventos de Clique ---
    // Lógica para abrir/fechar o painel de busca
    btnToggleBusca.addEventListener('click', (event) => {
        event.preventDefault();
        buscaContainer.classList.toggle('hidden');
    });

    // Lógica para o botão "Filtrar Leilões"
    btnFiltrar.addEventListener('click', () => {
        const filtros = {
            localizacao: inputLocalizacao.value,
            preco_min: inputPrecoMin.value,
            preco_max: inputPrecoMax.value,
        };
        Object.keys(filtros).forEach(key => {
            if (!filtros[key]) {
                delete filtros[key];
            }
        });
        carregarLeiloes(filtros);
    });

    // Lógica para fechar o painel ao clicar fora
    document.addEventListener('click', function(event) {
        if (!btnToggleBusca.contains(event.target) && !buscaContainer.contains(event.target)) {
            buscaContainer.classList.add('hidden');
        }
    });

    // ================================================================
    //   BLOCO NOVO: Lógica do clique no botão 'Ver Anúncio' (Contador)
    // ================================================================
    leiloesGrid.addEventListener('click', async function(event) {
        const botao = event.target.closest('.ver-anuncio-btn');
        if (!botao) {
            return;
        }

        event.preventDefault();

        const leilaoId = botao.dataset.leilaoId;
        const urlDestino = botao.href;

        try {
            await fetch(`/api/leiloes/${leilaoId}/increment-view`, {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                }
            });
        } catch (error) {
            console.error('Não foi possível incrementar a visualização:', error);
        } finally {
            // Redireciona o usuário para o destino final
            window.location.href = urlDestino;
        }
    });


    // --- Bloco Final: Execução Inicial ---
    // Carrega todos os leilões quando a página abre
    carregarLeiloes();
});
</script>
</body>
</html> 