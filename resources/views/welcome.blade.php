<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="icon" href="{{ asset('images/favicon.png') }}" type="image/png">
    <title>Fernanda Freire - Leiloeira Oficial</title>

    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css" />
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;700&display=swap" rel="stylesheet">
</head>

<body>
    <header class="header-container">
    <button class="mobile-menu-toggle" aria-label="Abrir Menu">
        <span class="bar"></span>
        <span class="bar"></span>
        <span class="bar"></span>
    </button>

    <div class="logo-container">
        <a href="/">
            <img src="{{ asset('images/fernandaLogo.png') }}" alt="Logo Fernanda Freire Leilões">
        </a>
    </div>

    <nav>
        <ul>
            <li><a href="#">Home</a></li>
            <li><a href="https://www.fernandafreireleiloes.com.br/quem-somos">Sobre a Leiloeira</a></li>
            <li><a href="https://www.fernandafreireleiloes.com.br/">Leilões</a></li>
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

    <section class="swiper-container">
        <div class="swiper">
            <div class="swiper-wrapper"></div>
            <div class="swiper-pagination"></div>
            <div class="swiper-button-prev"></div>
            <div class="swiper-button-next"></div>
        </div>
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
                    <li><a href="https://www.fernandafreireleiloes.com.br/quem-somos">Sobre a Leiloeira</a></li>
                    <li><a href="https://www.fernandafreireleiloes.com.br/">Leilões</a></li>
                </ul>
            </div>
            <div class="footer-column">
                <h4>Redes Sociais</h4>
                <div class="social-links">
                    <a href="#">Facebook</a>
                    <a href="#">Instagram</a>
                    <a href="#">LinkedIn</a>
                </div>
            </div>
        </div>
        <div class="footer-bottom">
            <p>&copy; {{ date('Y') }} Fernanda Freire Leilões. Todos os direitos reservados.</p>
        </div>
    </footer>
    <script src="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js"></script>
    <script>
// Espera todo o conteúdo HTML da página ser carregado antes de executar o script
document.addEventListener('DOMContentLoaded', () => {

    // --- Bloco 1: Seleção dos Elementos ---
    const leiloesGrid = document.getElementById('leiloes-grid');
    const btnFiltrar = document.getElementById('btn-filtrar');
    const inputLocalizacao = document.getElementById('filtro-localizacao');
    const inputPrecoMin = document.getElementById('filtro-preco-min');
    const inputPrecoMax = document.getElementById('filtro-preco-max');
    const btnToggleBusca = document.getElementById('btn-toggle-busca');
    const buscaContainer = document.querySelector('.busca-container');
    const btnVejaMaisContainer = document.querySelector('.veja-mais-container');
    const btnVejaMais = document.querySelector('.btn-veja-mais');
    const swiperWrapper = document.querySelector('.swiper-wrapper');
    const mobileMenuToggle = document.querySelector('.mobile-menu-toggle');
    const navMenu = document.querySelector('.header-container nav');

    // --- Bloco 2: Variáveis de Estado ---
    let currentPage = 1;
    let lastPage = 1;
    let isLoading = false;
    let currentFilters = {};

    // --- Bloco 3: Funções Auxiliares ---
    const formatarMoeda = (valor) => {
        const numero = parseFloat(valor);
        return new Intl.NumberFormat('pt-BR', { style: 'currency', currency: 'BRL' }).format(numero);
    };

    // --- Bloco 4: Funções de Carga de Dados ---
    async function carregarBanners() {
        try {
            const response = await fetch('/api/banners');
            const banners = await response.json();
            if (!swiperWrapper || banners.length === 0) return;
            banners.forEach(banner => {
                const slideHtml = `
                    <div class="swiper-slide">
                        <a href="${banner.link_url || '#'}"><img src="${banner.image_path}" alt="Banner Promocional"></a>
                    </div>`;
                swiperWrapper.innerHTML += slideHtml;
            });
            new Swiper('.swiper', {
                loop: true,
                autoplay: { delay: 5000, disableOnInteraction: false },
                pagination: { el: '.swiper-pagination', clickable: true },
                navigation: { nextEl: '.swiper-button-next', prevEl: '.swiper-button-prev' },
            });
        } catch (error) { console.error('Erro ao carregar banners:', error); }
    }

    async function carregarLeiloes(replace = true) {
        if (isLoading) return;
        isLoading = true;
        btnVejaMais.textContent = 'Carregando...';
        if (replace) {
            currentPage = 1;
            leiloesGrid.innerHTML = '<p>Carregando leilões...</p>';
        }
        const queryParams = new URLSearchParams(currentFilters);
        try {
            const response = await fetch(`/api/leiloes?page=${currentPage}&${queryParams}`);
            const responseData = await response.json();
            const leiloes = responseData.data; 
            lastPage = responseData.last_page; 
            if (replace) leiloesGrid.innerHTML = '';
            if (!leiloes || leiloes.length === 0) {
                if(replace) leiloesGrid.innerHTML = '<p>Nenhum leilão encontrado.</p>';
                btnVejaMaisContainer.classList.add('hidden');
                return;
            }
            leiloes.forEach(leilao => {
                const cardHtml = `
                    <div class="card-leilao">
                        <img src="${leilao.url_imagem}" alt="${leilao.titulo}">
                        <div class="info">
                            <h3>${leilao.titulo}</h3>
                            <p class="endereco">${leilao.endereco}</p>
                            <p class="matricula">Matrícula: ${leilao.matricula}</p>
                            <p class="view-count">👁️ ${leilao.view_count} visualizações</p>
                            <div class="preco">
                                <p class="avaliacao">Avaliação: ${formatarMoeda(leilao.valor_avaliacao)}</p>
                                <p class="preco-atual">Preço atual: ${formatarMoeda(leilao.preco_atual)}</p>
                            </div>
                        </div>
                        <a href="${leilao.url_anuncio}" class="ver-anuncio-btn" data-leilao-id="${leilao.id}">VER ANÚNCIO</a>
                    </div>`;
                leiloesGrid.insertAdjacentHTML('beforeend', cardHtml);
            });
            if (currentPage >= lastPage) {
                btnVejaMaisContainer.classList.add('hidden');
            } else {
                btnVejaMaisContainer.classList.remove('hidden');
            }
        } catch (error) {
            console.error('Erro ao carregar leilões:', error);
        } finally {
            isLoading = false;
            btnVejaMais.textContent = 'VEJA MAIS LEILÕES';
        }
    }

    // --- Bloco 5: Lógica dos Eventos de Clique ---
    // Lógica para o menu hambúrguer (mobile)
    mobileMenuToggle.addEventListener('click', () => {
    navMenu.classList.toggle('nav-active');
    mobileMenuToggle.classList.toggle('is-active'); // ADICIONE ESTA LINHA
});

    // Lógica para abrir/fechar o painel de busca
    btnToggleBusca.addEventListener('click', (event) => { event.preventDefault(); buscaContainer.classList.toggle('hidden'); });
    
    // Lógica para fechar o painel ao clicar fora
    document.addEventListener('click', function(event) { if (!btnToggleBusca.contains(event.target) && !buscaContainer.contains(event.target)) { buscaContainer.classList.add('hidden'); } });
    
    // Lógica do botão de filtrar
    btnFiltrar.addEventListener('click', () => {
        currentFilters = {
            localizacao: inputLocalizacao.value,
            preco_min: inputPrecoMin.value,
            preco_max: inputPrecoMax.value,
        };
        Object.keys(currentFilters).forEach(key => { if (!currentFilters[key]) { delete currentFilters[key]; } });
        carregarLeiloes(true);
    });

    // Lógica do botão "Veja Mais"
    btnVejaMais.addEventListener('click', (event) => {
        event.preventDefault();
        currentPage++;
        carregarLeiloes(false);
    });

    // Lógica do clique no botão 'Ver Anúncio' (Contador)
    leiloesGrid.addEventListener('click', async function(event) {
        const botao = event.target.closest('.ver-anuncio-btn');
        if (!botao) { return; }
        event.preventDefault();
        const card = botao.closest('.card-leilao');
        if (card) {
            const contadorElemento = card.querySelector('.view-count');
            if (contadorElemento) {
                try {
                    let contagemAtual = parseInt(contadorElemento.textContent.match(/\d+/)[0] || 0);
                    contagemAtual++;
                    contadorElemento.textContent = `👁️ ${contagemAtual} visualizações`;
                } catch (e) { console.error("Não foi possível atualizar o contador visualmente.", e); }
            }
        }
        const leilaoId = botao.dataset.leilaoId;
        const urlDestino = botao.href;
        try {
            await fetch(`/api/leiloes/${leilaoId}/increment-view`, {
                method: 'POST',
                headers: { 'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content') }
            });
        } catch (error) {
            console.error('Não foi possível incrementar a visualização no servidor:', error);
        } finally {
            window.location.href = urlDestino;
        }
    });

    // --- Bloco Final: Carga Inicial ---
    carregarBanners();
    carregarLeiloes(true);
});
    </script>
</body>

</html>