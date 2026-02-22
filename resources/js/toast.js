function ensureContainer() {
  let container = document.getElementById('toast-container');
  if (!container) {
    container = document.createElement('div');
    container.id = 'toast-container';
    container.className = 'fixed top-4 right-4 z-50 flex flex-col gap-3 w-[min(92vw,380px)]';
    document.body.appendChild(container);
  }
  return container;
}

function typeClasses(type) {
  switch (type) {
    case 'success':
      return 'border-green-200 bg-green-50 text-green-900';
    case 'error':
      return 'border-red-200 bg-red-50 text-red-900';
    case 'warning':
      return 'border-yellow-200 bg-yellow-50 text-yellow-900';
    default:
      return 'border-slate-200 bg-white text-slate-900';
  }
}

export function toast(message, type = 'info', opts = {}) {
  if (!message) return;
  const container = ensureContainer();

  const el = document.createElement('div');
  el.className = `border ${typeClasses(type)} shadow-sm rounded-xl p-4 flex gap-3 items-start`;
  el.setAttribute('role', 'status');

  const icon = document.createElement('div');
  icon.className = 'mt-0.5 text-lg leading-none select-none';
  icon.textContent = type === 'success' ? '✅' : type === 'error' ? '⛔' : type === 'warning' ? '⚠️' : 'ℹ️';

  const body = document.createElement('div');
  body.className = 'flex-1';

  const text = document.createElement('div');
  text.className = 'text-sm font-medium';
  text.textContent = message;

  const actions = document.createElement('div');
  actions.className = 'ml-2';

  const btn = document.createElement('button');
  btn.type = 'button';
  btn.className = 'text-slate-500 hover:text-slate-800 text-sm';
  btn.textContent = '✕';
  btn.addEventListener('click', () => {
    el.classList.add('opacity-0', 'translate-x-2');
    setTimeout(() => el.remove(), 150);
  });

  actions.appendChild(btn);
  body.appendChild(text);

  el.appendChild(icon);
  el.appendChild(body);
  el.appendChild(actions);

  el.classList.add('transition', 'duration-150');
  container.appendChild(el);

  const duration = opts.duration ?? (type === 'error' ? 6000 : 3500);
  if (duration > 0) {
    setTimeout(() => btn.click(), duration);
  }
}

export function bootFlashToasts() {
  const node = document.getElementById('flash-data');
  if (!node) return;

  try {
    const data = JSON.parse(node.textContent || '{}');
    if (data.success) toast(data.success, 'success');
    if (data.error) toast(data.error, 'error');
    if (Array.isArray(data.errors) && data.errors.length) {
      // Mostra até 3 erros pra não lotar a tela
      data.errors.slice(0, 3).forEach((e) => toast(e, 'error', { duration: 7000 }));
      if (data.errors.length > 3) toast(`Mais ${data.errors.length - 3} erro(s).`, 'warning');
    }
  } catch (_) {
    // ignora
  }
}
