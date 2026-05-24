import { useState } from 'react'
import { ShieldCheck, Search, CheckCircle2, XCircle, FileText, ClipboardList, AlertCircle } from 'lucide-react'

const MOCK_DOCS = {
  'VM-2024-001234': {
    tipo: 'Atestado Médico',
    paciente: 'João da Silva',
    medico: 'Dr. Carlos Mendes',
    crm: 'CRM/SP 123456',
    dataEmissao: '2024-11-10',
    valido: true,
  },
  'VM-2024-005678': {
    tipo: 'Receita Médica',
    paciente: 'Maria Oliveira',
    medico: 'Dra. Ana Beatriz',
    crm: 'CRM/MG 654321',
    dataEmissao: '2024-11-08',
    valido: true,
  },
}

export default function Verificar() {
  const [codigo, setCodigo] = useState('')
  const [resultado, setResultado] = useState(null)
  const [loading, setLoading] = useState(false)
  const [searched, setSearched] = useState(false)

  const handleVerificar = (e) => {
    e.preventDefault()
    if (!codigo.trim()) return
    setLoading(true)
    setSearched(false)
    setTimeout(() => {
      const doc = MOCK_DOCS[codigo.trim().toUpperCase()] || null
      setResultado(doc)
      setSearched(true)
      setLoading(false)
    }, 1200)
  }

  return (
    <div className="max-w-3xl mx-auto px-4 sm:px-6 py-10">
      <div className="mb-8 text-center">
        <div className="w-14 h-14 bg-purple-100 rounded-2xl flex items-center justify-center mx-auto mb-4">
          <ShieldCheck className="w-7 h-7 text-purple-600" />
        </div>
        <h1 className="text-3xl font-bold text-gray-900 mb-2">Verificar Documento</h1>
        <p className="text-gray-500 max-w-md mx-auto">
          Insira o código ou escaneie o QR Code do documento para verificar sua autenticidade em tempo real.
        </p>
      </div>

      <div className="bg-white border border-gray-200 rounded-2xl p-8 card-shadow mb-8">
        <form onSubmit={handleVerificar} className="flex flex-col sm:flex-row gap-3">
          <input
            type="text"
            value={codigo}
            onChange={e => setCodigo(e.target.value)}
            placeholder="Ex: VM-2024-001234"
            className="flex-1 border border-gray-200 rounded-xl px-4 py-3 text-sm text-gray-900 focus:outline-none focus:ring-2 focus:ring-purple-400 focus:border-transparent transition placeholder-gray-400 font-mono"
          />
          <button
            type="submit"
            disabled={loading || !codigo.trim()}
            className="inline-flex items-center justify-center gap-2 px-6 py-3 bg-purple-600 text-white font-semibold rounded-xl hover:bg-purple-700 transition-colors disabled:opacity-50 disabled:cursor-not-allowed"
          >
            {loading ? (
              <svg className="animate-spin w-4 h-4 text-white" viewBox="0 0 24 24" fill="none">
                <circle className="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" strokeWidth="4"/>
                <path className="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8v8z"/>
              </svg>
            ) : (
              <Search className="w-4 h-4" />
            )}
            Verificar
          </button>
        </form>

        <p className="text-xs text-gray-400 mt-3 text-center">
          Tente os códigos de exemplo: <span className="font-mono font-semibold text-gray-600">VM-2024-001234</span> ou <span className="font-mono font-semibold text-gray-600">VM-2024-005678</span>
        </p>
      </div>

      {searched && resultado && (
        <div className="bg-white border-2 border-emerald-200 rounded-2xl p-8 card-shadow">
          <div className="flex items-center gap-3 mb-6">
            <div className="w-12 h-12 bg-emerald-100 rounded-xl flex items-center justify-center">
              <CheckCircle2 className="w-6 h-6 text-emerald-600" />
            </div>
            <div>
              <h2 className="text-lg font-bold text-emerald-700">Documento Autêntico</h2>
              <p className="text-sm text-gray-500">Verificado com sucesso na base Verificamed</p>
            </div>
          </div>

          <div className="grid grid-cols-1 sm:grid-cols-2 gap-4 bg-gray-50 rounded-xl p-5">
            <div>
              <p className="text-xs text-gray-400 uppercase tracking-wider mb-1">Tipo de Documento</p>
              <div className="flex items-center gap-2">
                {resultado.tipo === 'Atestado Médico'
                  ? <FileText className="w-4 h-4 text-blue-500" />
                  : <ClipboardList className="w-4 h-4 text-emerald-500" />
                }
                <p className="font-semibold text-gray-900 text-sm">{resultado.tipo}</p>
              </div>
            </div>
            <div>
              <p className="text-xs text-gray-400 uppercase tracking-wider mb-1">Código</p>
              <p className="font-mono font-semibold text-gray-900 text-sm">{codigo.toUpperCase()}</p>
            </div>
            <div>
              <p className="text-xs text-gray-400 uppercase tracking-wider mb-1">Paciente</p>
              <p className="font-semibold text-gray-900 text-sm">{resultado.paciente}</p>
            </div>
            <div>
              <p className="text-xs text-gray-400 uppercase tracking-wider mb-1">Médico Responsável</p>
              <p className="font-semibold text-gray-900 text-sm">{resultado.medico}</p>
            </div>
            <div>
              <p className="text-xs text-gray-400 uppercase tracking-wider mb-1">CRM</p>
              <p className="font-semibold text-gray-900 text-sm">{resultado.crm}</p>
            </div>
            <div>
              <p className="text-xs text-gray-400 uppercase tracking-wider mb-1">Data de Emissão</p>
              <p className="font-semibold text-gray-900 text-sm">{resultado.dataEmissao}</p>
            </div>
          </div>

          <div className="mt-5 flex items-center gap-2 text-xs text-emerald-700 bg-emerald-50 rounded-xl p-3 border border-emerald-200">
            <ShieldCheck className="w-4 h-4 flex-shrink-0" />
            <span>Assinatura digital válida — Documento íntegro e não adulterado conforme Lei 14.063/2020</span>
          </div>
        </div>
      )}

      {searched && !resultado && (
        <div className="bg-white border-2 border-red-200 rounded-2xl p-8 card-shadow">
          <div className="flex items-center gap-3 mb-4">
            <div className="w-12 h-12 bg-red-100 rounded-xl flex items-center justify-center">
              <XCircle className="w-6 h-6 text-red-600" />
            </div>
            <div>
              <h2 className="text-lg font-bold text-red-700">Documento não encontrado</h2>
              <p className="text-sm text-gray-500">Nenhum registro localizado para este código</p>
            </div>
          </div>
          <div className="bg-red-50 rounded-xl p-4 flex items-start gap-3 text-sm text-red-700 border border-red-200">
            <AlertCircle className="w-4 h-4 mt-0.5 flex-shrink-0" />
            <p>
              O código <span className="font-mono font-bold">{codigo}</span> não foi encontrado em nossa base de dados.
              Verifique se o código foi digitado corretamente ou entre em contato com o médico emissor.
            </p>
          </div>
        </div>
      )}

      <div className="mt-10 grid grid-cols-1 sm:grid-cols-3 gap-4">
        {[
          { icon: ShieldCheck, title: 'Verificação Instantânea', desc: 'Resultado em menos de 2 segundos', color: 'text-purple-600 bg-purple-50' },
          { icon: CheckCircle2, title: 'Dados Criptografados', desc: 'Comunicação 100% segura via TLS', color: 'text-emerald-600 bg-emerald-50' },
          { icon: FileText, title: 'Base Centralizada', desc: 'Todos os documentos Verificamed', color: 'text-blue-600 bg-blue-50' },
        ].map(({ icon: Icon, title, desc, color }) => (
          <div key={title} className="bg-white border border-gray-100 rounded-xl p-4 flex items-center gap-3">
            <div className={`w-10 h-10 rounded-lg flex items-center justify-center flex-shrink-0 ${color}`}>
              <Icon className="w-5 h-5" />
            </div>
            <div>
              <p className="text-sm font-semibold text-gray-900">{title}</p>
              <p className="text-xs text-gray-400">{desc}</p>
            </div>
          </div>
        ))}
      </div>
    </div>
  )
}
