// ── Scroll progress bar ────────────────────────────────────────────────────
(function () {
  var bar = document.getElementById('scroll-progress');
  if (!bar) return;
  function update() {
    var scrolled = window.scrollY;
    var total = document.documentElement.scrollHeight - window.innerHeight;
    bar.style.width = (total > 0 ? Math.min(100, (scrolled / total) * 100) : 0) + '%';
  }
  window.addEventListener('scroll', update, { passive: true });
  update();
})();

// ── Scroll reveal ──────────────────────────────────────────────────────────
(function () {
  var selectors = '.reveal, .reveal-left, .reveal-right, .reveal-scale';
  var els = document.querySelectorAll(selectors);
  if (!els.length) return;
  var io = new IntersectionObserver(function (entries) {
    entries.forEach(function (e) {
      if (e.isIntersecting) {
        e.target.classList.add('visible');
        io.unobserve(e.target);
      }
    });
  }, { threshold: 0.12, rootMargin: '0px 0px -40px 0px' });
  els.forEach(function (el) { io.observe(el); });
})();

document.addEventListener('DOMContentLoaded', function () {
  const btn = document.getElementById('mobile-menu-btn');
  const menu = document.getElementById('nav-links');
  if (btn && menu) {
    btn.addEventListener('click', function () {
      menu.classList.toggle('open');
    });
  }

  // Live preview for Atestado
  initAtestadoPreview();

  // Live preview for Receita
  initReceitaPreview();

  // Medication list (Receita)
  initMedicamentos();
});

// ── Atestado live preview ──────────────────────────────────────────────────
function initAtestadoPreview() {
  const fields = [
    'nomePaciente','cpfPaciente','dataNascimento',
    'nomeMedico','crmMedico','especialidade',
    'diasAfastamento','dataEmissao','cid','observacoes'
  ];
  fields.forEach(function(id) {
    var el = document.getElementById(id);
    if (el) el.addEventListener('input', updateAtestadoPreview);
  });
  updateAtestadoPreview();
}

function val(id) {
  var el = document.getElementById(id);
  return el ? el.value.trim() : '';
}

function updateAtestadoPreview() {
  set('prev-nomeMedico', val('nomeMedico') || '________________________');
  set('prev-crmMedico', val('crmMedico') || '______');
  set('prev-especialidade', val('especialidade') ? ', especialidade ' + val('especialidade') + ',' : ',');
  set('prev-nomePaciente', val('nomePaciente') || '—');
  set('prev-cpfPaciente', val('cpfPaciente') || '—');
  set('prev-dataNascimento', val('dataNascimento') || '—');
  set('prev-cid', val('cid') || '—');
  set('prev-dias', val('diasAfastamento') ? val('diasAfastamento') + ' dia(s)' : '___ dia(s)');
  set('prev-nomeMedico2', val('nomeMedico') || 'Nome do Médico');
  set('prev-crmMedico2', val('crmMedico') || '——');
  set('prev-dataEmissao', val('dataEmissao') || '—');

  var obsEl = document.getElementById('prev-observacoes-wrap');
  if (obsEl) {
    if (val('observacoes')) {
      obsEl.classList.remove('hidden');
      set('prev-observacoes', val('observacoes'));
    } else {
      obsEl.classList.add('hidden');
    }
  }
}

// ── Receita live preview ──────────────────────────────────────────────────
function initReceitaPreview() {
  var fields = [
    'nomePaciente','cpfPaciente','dataNascimento',
    'nomeMedico','crmMedico','especialidade',
    'dataEmissao','validade','observacoes'
  ];
  fields.forEach(function(id) {
    var el = document.getElementById(id);
    if (el) el.addEventListener('input', updateReceitaPreview);
  });
  updateReceitaPreview();
}

function updateReceitaPreview() {
  set('prev-nomePaciente', val('nomePaciente') || '—');
  set('prev-cpfPaciente', val('cpfPaciente') || '—');
  set('prev-dataNascimento', val('dataNascimento') || '—');
  set('prev-nomeMedico', val('nomeMedico') || 'Nome do Médico');
  set('prev-crmMedico', val('crmMedico') || '——');
  set('prev-especialidade', val('especialidade') || '');
  set('prev-dataEmissao', val('dataEmissao') || '—');

  var valEl = document.getElementById('prev-validade-wrap');
  if (valEl) {
    if (val('validade')) { valEl.classList.remove('hidden'); set('prev-validade', val('validade')); }
    else { valEl.classList.add('hidden'); }
  }

  var obsEl = document.getElementById('prev-observacoes-wrap');
  if (obsEl) {
    if (val('observacoes')) { obsEl.classList.remove('hidden'); set('prev-observacoes', val('observacoes')); }
    else { obsEl.classList.add('hidden'); }
  }

  updateMedPreview();
}

// ── Medications dynamic list ──────────────────────────────────────────────
var medCount = 1;

function initMedicamentos() {
  var addBtn = document.getElementById('add-med-btn');
  if (addBtn) addBtn.addEventListener('click', addMedicamento);
  updateMedPreview();
}

function addMedicamento() {
  medCount++;
  var container = document.getElementById('meds-container');
  if (!container) return;
  var div = document.createElement('div');
  div.className = 'bg-gray-50 rounded-xl p-4 relative';
  div.id = 'med-' + medCount;
  div.innerHTML = medBlock(medCount);
  container.appendChild(div);
  div.querySelectorAll('input').forEach(function(i) { i.addEventListener('input', updateMedPreview); });
  updateMedPreview();
}

function removeMedicamento(n) {
  var el = document.getElementById('med-' + n);
  if (el) el.remove();
  updateMedPreview();
}

function medBlock(n) {
  return '<div class="flex items-center justify-between mb-3">' +
    '<span class="text-xs font-bold text-emerald-700 uppercase tracking-wider">Medicamento ' + n + '</span>' +
    '<button type="button" onclick="removeMedicamento(' + n + ')" class="text-red-400 hover:text-red-600 text-xs font-semibold">Remover</button>' +
    '</div>' +
    '<div class="grid grid-cols-1 sm:grid-cols-2 gap-3">' +
    '<div class="flex flex-col gap-1"><label class="text-sm font-medium text-gray-700">Nome <span class="text-red-500">*</span></label>' +
    '<input class="input-field" placeholder="ex: Amoxicilina 500mg" name="med_nome[]" data-med="' + n + '"></div>' +
    '<div class="flex flex-col gap-1"><label class="text-sm font-medium text-gray-700">Dose</label>' +
    '<input class="input-field" placeholder="ex: 500mg" name="med_dose[]" data-med="' + n + '"></div>' +
    '<div class="flex flex-col gap-1"><label class="text-sm font-medium text-gray-700">Posologia</label>' +
    '<input class="input-field" placeholder="ex: 1 comp 8/8h" name="med_posologia[]" data-med="' + n + '"></div>' +
    '<div class="flex flex-col gap-1"><label class="text-sm font-medium text-gray-700">Quantidade</label>' +
    '<input class="input-field" placeholder="ex: 21 comprimidos" name="med_qtd[]" data-med="' + n + '"></div>' +
    '</div>';
}

function updateMedPreview() {
  var previewEl = document.getElementById('prev-meds');
  if (!previewEl) return;
  var names = document.querySelectorAll('[name="med_nome[]"]');
  var doses = document.querySelectorAll('[name="med_dose[]"]');
  var posols = document.querySelectorAll('[name="med_posologia[]"]');
  var qtds = document.querySelectorAll('[name="med_qtd[]"]');

  if (names.length === 0) {
    previewEl.innerHTML = '<p class="text-gray-400 italic text-xs">Nenhum medicamento adicionado.</p>';
    return;
  }
  var html = '<ol class="flex flex-col gap-3">';
  for (var i = 0; i < names.length; i++) {
    var n = names[i].value || 'Medicamento';
    var d = doses[i] ? doses[i].value : '';
    var p = posols[i] ? posols[i].value : '';
    var q = qtds[i] ? qtds[i].value : '';
    html += '<li class="flex gap-2"><span class="font-black text-emerald-400 text-base leading-none">' + (i+1) + '.</span><div>';
    html += '<p class="font-bold text-sm">' + escHtml(n) + '</p>';
    if (d) html += '<p class="text-xs text-gray-600">Dose: ' + escHtml(d) + '</p>';
    if (p) html += '<p class="text-xs text-gray-600">Posologia: ' + escHtml(p) + '</p>';
    if (q) html += '<p class="text-xs text-gray-600">Qtd: ' + escHtml(q) + '</p>';
    html += '</div></li>';
  }
  html += '</ol>';
  previewEl.innerHTML = html;
}

// ── Tab toggle ───────────────────────────────────────────────────────────
function switchTab(tab, formId, previewId, activeClass) {
  var form = document.getElementById(formId);
  var preview = document.getElementById(previewId);
  var btnForm = document.getElementById('tab-form');
  var btnPrev = document.getElementById('tab-preview');
  if (!form || !preview) return;
  if (tab === 'form') {
    form.classList.remove('hidden');
    preview.classList.add('hidden', 'lg:block');
    if (btnForm) { btnForm.className = 'px-5 py-2 rounded-lg text-sm font-semibold ' + activeClass; }
    if (btnPrev) { btnPrev.className = 'px-5 py-2 rounded-lg text-sm font-semibold bg-gray-100 text-gray-600 hover:bg-gray-200'; }
  } else {
    form.classList.add('hidden');
    preview.classList.remove('hidden', 'lg:block');
    if (btnForm) { btnForm.className = 'px-5 py-2 rounded-lg text-sm font-semibold bg-gray-100 text-gray-600 hover:bg-gray-200'; }
    if (btnPrev) { btnPrev.className = 'px-5 py-2 rounded-lg text-sm font-semibold ' + activeClass; }
  }
}

// ── Helpers ───────────────────────────────────────────────────────────────
function set(id, text) {
  var el = document.getElementById(id);
  if (el) el.textContent = text;
}
function escHtml(s) {
  return String(s).replace(/&/g,'&amp;').replace(/</g,'&lt;').replace(/>/g,'&gt;');
}

// Print document — iOS Safari compatible
function printDoc() {
  var isIOS = /iPad|iPhone|iPod/.test(navigator.userAgent) && !window.MSStream;
  if (isIOS) {
    // iOS Safari requires a short delay and focus before window.print()
    window.focus();
    setTimeout(function () { window.print(); }, 300);
  } else {
    window.print();
  }
}
