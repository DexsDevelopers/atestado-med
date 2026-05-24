import { useState } from 'react'
import { ClipboardList, Download, Send, CheckCircle2, AlertCircle, Plus, Trash2 } from 'lucide-react'

const initialForm = {
  nomePaciente: '',
  cpfPaciente: '',
  dataNascimento: '',
  nomeMedico: '',
  crmMedico: '',
  especialidade: '',
  dataEmissao: new Date().toISOString().split('T')[0],
  validade: '',
  observacoes: '',
}

const initialMed = { nome: '', dose: '', posologia: '', quantidade: '' }

function InputField({ label, id, required, ...props }) {
  return (
    <div className="flex flex-col gap-1">
      <label htmlFor={id} className="text-sm font-medium text-gray-700">
        {label} {required && <span className="text-red-500">*</span>}
      </label>
      <input
        id={id}
        className="border border-gray-200 rounded-lg px-3 py-2.5 text-sm text-gray-900 focus:outline-none focus:ring-2 focus:ring-emerald-400 focus:border-transparent transition placeholder-gray-400"
        {...props}
      />
    </div>
  )
}

function TextareaField({ label, id, ...props }) {
  return (
    <div className="flex flex-col gap-1">
      <label htmlFor={id} className="text-sm font-medium text-gray-700">{label}</label>
      <textarea
        id={id}
        rows={3}
        className="border border-gray-200 rounded-lg px-3 py-2.5 text-sm text-gray-900 focus:outline-none focus:ring-2 focus:ring-emerald-400 focus:border-transparent transition placeholder-gray-400 resize-none"
        {...props}
      />
    </div>
  )
}

function Preview({ form, medicamentos }) {
  return (
    <div className="bg-white border-2 border-gray-200 rounded-2xl p-8 font-serif text-gray-900 text-sm leading-relaxed">
      <div className="text-center border-b-2 border-gray-300 pb-5 mb-6">
        <h2 className="text-2xl font-bold tracking-wide uppercase">RECEITA MÉDICA</h2>
        <p className="text-xs text-gray-500 mt-1">Documento com validade jurídica — Verificamed</p>
      </div>

      <div className="mb-4">
        <p className="text-xs text-gray-500 uppercase tracking-wider mb-2 font-sans">Dados do Paciente</p>
        <div className="bg-gray-50 rounded-lg p-3 grid grid-cols-2 gap-2 text-xs font-sans">
          <div><span className="text-gray-500">Nome:</span> <strong>{form.nomePaciente || '—'}</strong></div>
          <div><span className="text-gray-500">CPF:</span> <strong>{form.cpfPaciente || '—'}</strong></div>
          <div><span className="text-gray-500">Nascimento:</span> <strong>{form.dataNascimento || '—'}</strong></div>
        </div>
      </div>

      <div className="mb-6">
        <p className="text-xs text-gray-500 uppercase tracking-wider mb-3 font-sans">Prescrição</p>
        {medicamentos.length === 0 ? (
          <p className="text-gray-400 italic text-xs font-sans">Nenhum medicamento adicionado.</p>
        ) : (
          <ol className="flex flex-col gap-4">
            {medicamentos.map((m, i) => (
              <li key={i} className="flex gap-3">
                <span className="font-black text-emerald-400 text-lg leading-none">{i + 1}.</span>
                <div>
                  <p className="font-bold">{m.nome || 'Medicamento'}</p>
                  {m.dose && <p className="text-xs text-gray-600">Dose: {m.dose}</p>}
                  {m.posologia && <p className="text-xs text-gray-600">Posologia: {m.posologia}</p>}
                  {m.quantidade && <p className="text-xs text-gray-600">Quantidade: {m.quantidade}</p>}
                </div>
              </li>
            ))}
          </ol>
        )}
      </div>

      {form.observacoes && (
        <p className="text-xs italic text-gray-600 mb-4 font-sans">Obs: {form.observacoes}</p>
      )}

      <div className="border-t border-gray-200 mt-6 pt-5 text-center font-sans">
        <div className="w-40 border-b border-gray-700 mx-auto mb-1" />
        <p className="text-xs font-semibold">{form.nomeMedico || 'Nome do Médico'}</p>
        <p className="text-xs text-gray-500">CRM {form.crmMedico || '——'}</p>
        {form.especialidade && <p className="text-xs text-gray-400">{form.especialidade}</p>}
        <p className="text-xs text-gray-400 mt-2">Data: {form.dataEmissao}</p>
        {form.validade && <p className="text-xs text-gray-400">Válida até: {form.validade}</p>}
      </div>

      <div className="flex justify-center mt-6">
        <div className="w-16 h-16 bg-gray-100 border border-gray-300 rounded flex items-center justify-center text-xs text-gray-400 text-center">
          QR Code<br />verificação
        </div>
      </div>
    </div>
  )
}

export default function Receita() {
  const [form, setForm] = useState(initialForm)
  const [medicamentos, setMedicamentos] = useState([{ ...initialMed }])
  const [submitted, setSubmitted] = useState(false)
  const [loading, setLoading] = useState(false)
  const [tab, setTab] = useState('form')

  const set = (field) => (e) => setForm(f => ({ ...f, [field]: e.target.value }))
  const setMed = (i, field) => (e) => setMedicamentos(ms => ms.map((m, idx) => idx === i ? { ...m, [field]: e.target.value } : m))
  const addMed = () => setMedicamentos(ms => [...ms, { ...initialMed }])
  const removeMed = (i) => setMedicamentos(ms => ms.filter((_, idx) => idx !== i))

  const handleSubmit = (e) => {
    e.preventDefault()
    setLoading(true)
    setTimeout(() => { setLoading(false); setSubmitted(true) }, 1500)
  }

  if (submitted) {
    return (
      <div className="max-w-3xl mx-auto px-4 sm:px-6 py-16 text-center">
        <div className="w-16 h-16 bg-emerald-100 rounded-full flex items-center justify-center mx-auto mb-4">
          <CheckCircle2 className="w-8 h-8 text-emerald-600" />
        </div>
        <h2 className="text-2xl font-bold text-gray-900 mb-2">Receita emitida com sucesso!</h2>
        <p className="text-gray-500 mb-8">Sua receita foi gerada e está pronta para download ou envio ao paciente.</p>
        <div className="bg-white border border-gray-200 rounded-2xl p-6 mb-8 text-left">
          <Preview form={form} medicamentos={medicamentos} />
        </div>
        <div className="flex flex-col sm:flex-row gap-3 justify-center">
          <button className="inline-flex items-center gap-2 px-6 py-3 bg-emerald-600 text-white font-semibold rounded-xl hover:bg-emerald-700 transition-colors">
            <Download className="w-4 h-4" /> Baixar PDF
          </button>
          <button className="inline-flex items-center gap-2 px-6 py-3 bg-primary-600 text-white font-semibold rounded-xl hover:bg-primary-700 transition-colors">
            <Send className="w-4 h-4" /> Enviar ao Paciente
          </button>
          <button
            onClick={() => { setSubmitted(false); setForm(initialForm); setMedicamentos([{ ...initialMed }]) }}
            className="inline-flex items-center gap-2 px-6 py-3 bg-gray-100 text-gray-700 font-semibold rounded-xl hover:bg-gray-200 transition-colors"
          >
            Nova Receita
          </button>
        </div>
      </div>
    )
  }

  return (
    <div className="max-w-6xl mx-auto px-4 sm:px-6 py-10">
      <div className="mb-8">
        <div className="flex items-center gap-3 mb-2">
          <div className="w-10 h-10 rounded-xl bg-emerald-100 flex items-center justify-center">
            <ClipboardList className="w-5 h-5 text-emerald-600" />
          </div>
          <h1 className="text-2xl font-bold text-gray-900">Receita Médica</h1>
        </div>
        <p className="text-gray-500">Preencha os dados para emitir uma receita médica digital.</p>
      </div>

      <div className="flex gap-2 mb-6">
        {['form', 'preview'].map(t => (
          <button
            key={t}
            onClick={() => setTab(t)}
            className={`px-5 py-2 rounded-lg text-sm font-semibold transition-colors ${tab === t ? 'bg-emerald-600 text-white' : 'bg-gray-100 text-gray-600 hover:bg-gray-200'}`}
          >
            {t === 'form' ? 'Formulário' : 'Pré-visualização'}
          </button>
        ))}
      </div>

      <div className="grid grid-cols-1 lg:grid-cols-2 gap-8">
        <form onSubmit={handleSubmit} className={`flex flex-col gap-5 ${tab === 'preview' ? 'hidden lg:flex' : ''}`}>
          <div className="bg-white border border-gray-200 rounded-2xl p-6">
            <h3 className="font-semibold text-gray-900 mb-4 pb-2 border-b border-gray-100">Dados do Paciente</h3>
            <div className="grid grid-cols-1 sm:grid-cols-2 gap-4">
              <InputField label="Nome completo" id="nomePaciente" required placeholder="Nome do paciente" value={form.nomePaciente} onChange={set('nomePaciente')} />
              <InputField label="CPF" id="cpfPaciente" placeholder="000.000.000-00" value={form.cpfPaciente} onChange={set('cpfPaciente')} />
              <InputField label="Data de nascimento" id="dataNascimento" type="date" value={form.dataNascimento} onChange={set('dataNascimento')} />
            </div>
          </div>

          <div className="bg-white border border-gray-200 rounded-2xl p-6">
            <h3 className="font-semibold text-gray-900 mb-4 pb-2 border-b border-gray-100">Dados do Médico</h3>
            <div className="grid grid-cols-1 sm:grid-cols-2 gap-4">
              <InputField label="Nome do médico" id="nomeMedico" required placeholder="Dr(a). Nome" value={form.nomeMedico} onChange={set('nomeMedico')} />
              <InputField label="CRM" id="crmMedico" required placeholder="CRM/UF 000000" value={form.crmMedico} onChange={set('crmMedico')} />
              <InputField label="Especialidade" id="especialidade" placeholder="ex: Cardiologista" value={form.especialidade} onChange={set('especialidade')} />
            </div>
          </div>

          <div className="bg-white border border-gray-200 rounded-2xl p-6">
            <div className="flex items-center justify-between mb-4 pb-2 border-b border-gray-100">
              <h3 className="font-semibold text-gray-900">Medicamentos</h3>
              <button type="button" onClick={addMed} className="inline-flex items-center gap-1 text-xs font-semibold text-emerald-600 hover:text-emerald-700">
                <Plus className="w-3.5 h-3.5" /> Adicionar
              </button>
            </div>
            <div className="flex flex-col gap-5">
              {medicamentos.map((m, i) => (
                <div key={i} className="bg-gray-50 rounded-xl p-4 relative">
                  <div className="flex items-center justify-between mb-3">
                    <span className="text-xs font-bold text-emerald-700 uppercase tracking-wider">Medicamento {i + 1}</span>
                    {medicamentos.length > 1 && (
                      <button type="button" onClick={() => removeMed(i)} className="text-red-400 hover:text-red-600 transition-colors">
                        <Trash2 className="w-4 h-4" />
                      </button>
                    )}
                  </div>
                  <div className="grid grid-cols-1 sm:grid-cols-2 gap-3">
                    <InputField label="Nome do medicamento" id={`nome-${i}`} required placeholder="ex: Amoxicilina 500mg" value={m.nome} onChange={setMed(i, 'nome')} />
                    <InputField label="Dose" id={`dose-${i}`} placeholder="ex: 500mg" value={m.dose} onChange={setMed(i, 'dose')} />
                    <InputField label="Posologia" id={`posologia-${i}`} placeholder="ex: 1 comprimido 8/8h" value={m.posologia} onChange={setMed(i, 'posologia')} />
                    <InputField label="Quantidade" id={`qtd-${i}`} placeholder="ex: 21 comprimidos" value={m.quantidade} onChange={setMed(i, 'quantidade')} />
                  </div>
                </div>
              ))}
            </div>
          </div>

          <div className="bg-white border border-gray-200 rounded-2xl p-6">
            <h3 className="font-semibold text-gray-900 mb-4 pb-2 border-b border-gray-100">Informações Adicionais</h3>
            <div className="grid grid-cols-1 sm:grid-cols-2 gap-4">
              <InputField label="Data de emissão" id="dataEmissao" required type="date" value={form.dataEmissao} onChange={set('dataEmissao')} />
              <InputField label="Válida até" id="validade" type="date" value={form.validade} onChange={set('validade')} />
              <div className="sm:col-span-2">
                <TextareaField label="Observações" id="observacoes" placeholder="Recomendações adicionais (opcional)" value={form.observacoes} onChange={set('observacoes')} />
              </div>
            </div>
          </div>

          <div className="flex items-start gap-3 bg-amber-50 border border-amber-200 rounded-xl p-4 text-sm text-amber-800">
            <AlertCircle className="w-4 h-4 mt-0.5 flex-shrink-0" />
            <p>Receita emitida com validade jurídica conforme a Lei 14.063/2020. Verifique todos os dados antes de emitir.</p>
          </div>

          <button
            type="submit"
            disabled={loading}
            className="w-full py-3.5 bg-emerald-600 text-white font-semibold rounded-xl hover:bg-emerald-700 transition-colors disabled:opacity-60 disabled:cursor-not-allowed flex items-center justify-center gap-2"
          >
            {loading ? (
              <>
                <svg className="animate-spin w-4 h-4 text-white" viewBox="0 0 24 24" fill="none"><circle className="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" strokeWidth="4"/><path className="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8v8z"/></svg>
                Gerando receita...
              </>
            ) : (
              <>
                <ClipboardList className="w-4 h-4" /> Gerar Receita
              </>
            )}
          </button>
        </form>

        <div className={tab === 'form' ? 'hidden lg:block' : ''}>
          <p className="text-xs text-gray-400 mb-3 font-medium uppercase tracking-wider">Pré-visualização do documento</p>
          <Preview form={form} medicamentos={medicamentos} />
        </div>
      </div>
    </div>
  )
}
