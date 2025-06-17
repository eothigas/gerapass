// Executa após o DOM estar pronto
$(function () {
  TFP.menuMobile();
  TFP.menuMobileScroll();
  TFP.menuAnimate();
});

const TFP = {
  // Inicializa o menu responsivo SlickNav
  menuMobile: function () {
    const logoHtml = $('.logo-cliente').html(); // Pega o HTML da logo

    $('.menu-list').slicknav({
      brand: logoHtml,
      label: '',
      prependTo: 'header',
      removeClasses: true
    });
  },

  // Adiciona classe ao menu ao rolar a página
  menuMobileScroll: function () {
    $(document).on('scroll', function () {
      const mainOffset = $('main').offset().top;

      if ($(window).scrollTop() > mainOffset) {
        $('.slicknav_menu').addClass('slicknav_scroll');
      } else {
        $('.slicknav_menu').removeClass('slicknav_scroll');
      }
    });
  },

  // Anima o ícone do menu hambúrguer ao abrir/fechar
  menuAnimate: function () {
    $(document).on('click', '.slicknav_icon', function () {
      $(this).toggleClass('active');
    });
  }
};
