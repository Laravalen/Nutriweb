document.addEventListener('DOMContentLoaded', () => {
  document.querySelectorAll('.protected-media').forEach((el) => {
    el.addEventListener('contextmenu', (e) => {
      e.preventDefault();
      alert('Conteúdo protegido por direitos autorais NutriWeb. Download não permitido.');
    });
  });

  document.addEventListener('keydown', (e) => {
    if ((e.ctrlKey || e.metaKey) && ['s', 'p', 'u'].includes(e.key.toLowerCase())) {
      if (document.querySelector('.protected-media')) {
        e.preventDefault();
        alert('Impressão e salvamento direto bloqueados para proteger a propriedade intelectual do chef.');
      }
    }
  });
});