import { Link } from 'react-router-dom'
import {
  FileText, ClipboardList, ShieldCheck, Clock, CheckCircle2,
  ArrowRight, Star, Users, Award, Zap
} from 'lucide-react'

const features = [
  {
    icon: FileText,
    title: 'Atestado Médico Digital',
    description: 'Emita atestados médicos com validade jurídica, assinatura digital e QR Code de verificação.',
    color: 'text-blue-600 bg-blue-50',
    href: '/atestado',
  },
  {
    icon: ClipboardList,
    title: 'Receita Médica Digital',
    description: 'Gere receitas médicas digitais seguras, reconhecidas por farmácias em todo o Brasil.',
    color: 'text-emerald-600 bg-emerald-50',
    href: '/receita',
  },
  {
    icon: ShieldCheck,
    title: 'Verificação de Autenticidade',
    description: 'Valide qualquer documento emitido pela plataforma de forma rápida e segura.',
    color: 'text-purple-600 bg-purple-50',
    href: '/verificar',
  },
]

const steps = [
  { step: '01', title: 'Preencha os dados', desc: 'Informe os dados do paciente e do médico responsável.' },
  { step: '02', title: 'Assine digitalmente', desc: 'O documento é assinado eletronicamente com certificado válido.' },
  { step: '03', title: 'Envie ao paciente', desc: 'Compartilhe o documento por e-mail, WhatsApp ou link direto.' },
  { step: '04', title: 'Verificação instantânea', desc: 'Qualquer pessoa pode verificar a autenticidade pelo QR Code.' },
]

const stats = [
  { icon: Users, value: '50.000+', label: 'Documentos emitidos' },
  { icon: Award, value: '99,9%', label: 'Disponibilidade' },
  { icon: Star, value: '4,9/5', label: 'Avaliação dos usuários' },
  { icon: Zap, value: '< 30s', label: 'Tempo de emissão' },
]

const testimonials = [
  {
    name: 'Dr. Carlos Mendes',
    role: 'Clínico Geral — São Paulo, SP',
    text: 'Uso o Verificamed diariamente no meu consultório. A praticidade de emitir atestados e receitas digitais transformou minha rotina.',
    stars: 5,
  },
  {
    name: 'Dra. Ana Beatriz',
    role: 'Pediatra — Belo Horizonte, MG',
    text: 'Meus pacientes adoram receber os documentos pelo WhatsApp. A verificação por QR Code passou confiança para todos.',
    stars: 5,
  },
  {
    name: 'Dr. Roberto Lima',
    role: 'Ortopedista — Rio de Janeiro, RJ',
    text: 'Finalmente uma plataforma simples, rápida e com total validade jurídica. Recomendo a todos os colegas.',
    stars: 5,
  },
]

export default function Home() {
  return (
    <div>
      {/* Hero */}
      <section className="relative overflow-hidden gradient-bg py-24 md:py-32">
        <div className="absolute inset-0 opacity-10"
          style={{ backgroundImage: 'radial-gradient(circle at 20% 80%, white 1px, transparent 1px), radial-gradient(circle at 80% 20%, white 1px, transparent 1px)', backgroundSize: '60px 60px' }}
        />
        <div className="relative max-w-6xl mx-auto px-4 sm:px-6 text-center">
          <span className="inline-flex items-center gap-2 bg-white/20 text-white text-sm font-medium px-4 py-1.5 rounded-full mb-6">
            <CheckCircle2 className="w-4 h-4" /> Documentos com validade jurídica
          </span>
          <h1 className="text-4xl md:text-6xl font-extrabold text-white leading-tight mb-6">
            Atestados e Receitas<br />
            <span className="text-sky-200">Médicas Digitais</span>
          </h1>
          <p className="text-lg md:text-xl text-blue-100 max-w-2xl mx-auto mb-10">
            Emita, assine e compartilhe documentos médicos com segurança, agilidade e validade jurídica reconhecida em todo o Brasil.
          </p>
          <div className="flex flex-col sm:flex-row gap-4 justify-center">
            <Link
              to="/atestado"
              className="inline-flex items-center gap-2 bg-white text-primary-700 font-semibold px-8 py-4 rounded-xl hover:bg-blue-50 transition-colors shadow-lg"
            >
              Emitir Atestado <ArrowRight className="w-4 h-4" />
            </Link>
            <Link
              to="/receita"
              className="inline-flex items-center gap-2 bg-white/15 text-white font-semibold px-8 py-4 rounded-xl hover:bg-white/25 transition-colors border border-white/30"
            >
              Emitir Receita <ArrowRight className="w-4 h-4" />
            </Link>
          </div>
        </div>
      </section>

      {/* Stats */}
      <section className="bg-white border-b border-gray-100">
        <div className="max-w-6xl mx-auto px-4 sm:px-6 py-10">
          <div className="grid grid-cols-2 md:grid-cols-4 gap-6">
            {stats.map(({ icon: Icon, value, label }) => (
              <div key={label} className="flex flex-col items-center text-center gap-1">
                <div className="w-10 h-10 rounded-xl bg-primary-50 flex items-center justify-center mb-1">
                  <Icon className="w-5 h-5 text-primary-600" />
                </div>
                <span className="text-2xl font-extrabold text-gray-900">{value}</span>
                <span className="text-sm text-gray-500">{label}</span>
              </div>
            ))}
          </div>
        </div>
      </section>

      {/* Features */}
      <section className="py-20 bg-gray-50">
        <div className="max-w-6xl mx-auto px-4 sm:px-6">
          <div className="text-center mb-14">
            <h2 className="text-3xl md:text-4xl font-bold text-gray-900 mb-4">Tudo que você precisa em um só lugar</h2>
            <p className="text-gray-500 max-w-xl mx-auto">Plataforma completa para médicos e pacientes gerenciarem documentos médicos digitais com segurança.</p>
          </div>
          <div className="grid grid-cols-1 md:grid-cols-3 gap-6">
            {features.map(({ icon: Icon, title, description, color, href }) => (
              <Link
                key={title}
                to={href}
                className="group bg-white rounded-2xl p-8 card-shadow border border-gray-100 hover:border-primary-200 hover:-translate-y-1 transition-all"
              >
                <div className={`w-12 h-12 rounded-xl flex items-center justify-center mb-5 ${color}`}>
                  <Icon className="w-6 h-6" />
                </div>
                <h3 className="text-lg font-bold text-gray-900 mb-2">{title}</h3>
                <p className="text-gray-500 text-sm leading-relaxed">{description}</p>
                <span className="mt-4 inline-flex items-center gap-1 text-primary-600 text-sm font-semibold group-hover:gap-2 transition-all">
                  Saiba mais <ArrowRight className="w-4 h-4" />
                </span>
              </Link>
            ))}
          </div>
        </div>
      </section>

      {/* How it works */}
      <section className="py-20 bg-white">
        <div className="max-w-6xl mx-auto px-4 sm:px-6">
          <div className="text-center mb-14">
            <h2 className="text-3xl md:text-4xl font-bold text-gray-900 mb-4">Como funciona?</h2>
            <p className="text-gray-500 max-w-xl mx-auto">Em menos de 30 segundos você emite um documento médico com total validade jurídica.</p>
          </div>
          <div className="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6 relative">
            {steps.map(({ step, title, desc }, i) => (
              <div key={step} className="relative">
                <div className="bg-gradient-to-br from-primary-50 to-white rounded-2xl p-6 border border-primary-100 h-full">
                  <span className="text-4xl font-black text-primary-200 leading-none">{step}</span>
                  <h4 className="text-base font-bold text-gray-900 mt-2 mb-1">{title}</h4>
                  <p className="text-sm text-gray-500 leading-relaxed">{desc}</p>
                </div>
                {i < steps.length - 1 && (
                  <div className="hidden lg:flex absolute top-10 -right-3 z-10 w-6 h-6 bg-white border border-primary-200 rounded-full items-center justify-center">
                    <ArrowRight className="w-3 h-3 text-primary-400" />
                  </div>
                )}
              </div>
            ))}
          </div>
        </div>
      </section>

      {/* Testimonials */}
      <section className="py-20 bg-gray-50">
        <div className="max-w-6xl mx-auto px-4 sm:px-6">
          <div className="text-center mb-14">
            <h2 className="text-3xl md:text-4xl font-bold text-gray-900 mb-4">O que dizem os médicos</h2>
            <p className="text-gray-500 max-w-xl mx-auto">Milhares de profissionais de saúde já confiam no Verificamed.</p>
          </div>
          <div className="grid grid-cols-1 md:grid-cols-3 gap-6">
            {testimonials.map(({ name, role, text, stars }) => (
              <div key={name} className="bg-white rounded-2xl p-6 card-shadow border border-gray-100">
                <div className="flex gap-1 mb-4">
                  {Array.from({ length: stars }).map((_, i) => (
                    <Star key={i} className="w-4 h-4 fill-amber-400 text-amber-400" />
                  ))}
                </div>
                <p className="text-gray-600 text-sm leading-relaxed mb-5">"{text}"</p>
                <div>
                  <p className="font-semibold text-gray-900 text-sm">{name}</p>
                  <p className="text-gray-400 text-xs">{role}</p>
                </div>
              </div>
            ))}
          </div>
        </div>
      </section>

      {/* CTA */}
      <section className="gradient-bg py-20">
        <div className="max-w-3xl mx-auto px-4 sm:px-6 text-center">
          <h2 className="text-3xl md:text-4xl font-bold text-white mb-4">Pronto para modernizar seu consultório?</h2>
          <p className="text-blue-100 mb-8 text-lg">Comece agora e emita seu primeiro documento em menos de 1 minuto.</p>
          <div className="flex flex-col sm:flex-row gap-4 justify-center">
            <Link
              to="/atestado"
              className="inline-flex items-center gap-2 bg-white text-primary-700 font-semibold px-8 py-4 rounded-xl hover:bg-blue-50 transition-colors shadow-lg"
            >
              Emitir Atestado <ArrowRight className="w-4 h-4" />
            </Link>
            <Link
              to="/receita"
              className="inline-flex items-center gap-2 bg-white/15 text-white font-semibold px-8 py-4 rounded-xl hover:bg-white/25 transition-colors border border-white/30"
            >
              Emitir Receita <ArrowRight className="w-4 h-4" />
            </Link>
          </div>
        </div>
      </section>
    </div>
  )
}
