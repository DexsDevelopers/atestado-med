import { Link } from 'react-router-dom'
import { Stethoscope, Mail, Phone, MapPin } from 'lucide-react'

export default function Footer() {
  return (
    <footer className="bg-gray-900 text-gray-300">
      <div className="max-w-6xl mx-auto px-4 sm:px-6 py-12">
        <div className="grid grid-cols-1 md:grid-cols-4 gap-8">
          <div className="md:col-span-2">
            <Link to="/" className="flex items-center gap-2 font-bold text-xl text-white mb-3">
              <div className="w-8 h-8 rounded-lg gradient-bg flex items-center justify-center">
                <Stethoscope className="w-4 h-4 text-white" />
              </div>
              Verificamed
            </Link>
            <p className="text-sm text-gray-400 leading-relaxed max-w-xs">
              Plataforma digital para emissão e verificação de atestados e receitas médicas com validade jurídica.
            </p>
            <div className="mt-4 flex flex-col gap-2 text-sm text-gray-400">
              <span className="flex items-center gap-2"><Mail className="w-4 h-4" /> contato@verificamed.website</span>
              <span className="flex items-center gap-2"><Phone className="w-4 h-4" /> (11) 99999-0000</span>
              <span className="flex items-center gap-2"><MapPin className="w-4 h-4" /> Brasil</span>
            </div>
          </div>

          <div>
            <h4 className="text-white font-semibold mb-3">Serviços</h4>
            <ul className="flex flex-col gap-2 text-sm">
              <li><Link to="/atestado" className="hover:text-white transition-colors">Atestado Médico</Link></li>
              <li><Link to="/receita" className="hover:text-white transition-colors">Receita Médica</Link></li>
              <li><Link to="/verificar" className="hover:text-white transition-colors">Verificar Documento</Link></li>
            </ul>
          </div>

          <div>
            <h4 className="text-white font-semibold mb-3">Institucional</h4>
            <ul className="flex flex-col gap-2 text-sm">
              <li><a href="#" className="hover:text-white transition-colors">Sobre nós</a></li>
              <li><a href="#" className="hover:text-white transition-colors">Política de Privacidade</a></li>
              <li><a href="#" className="hover:text-white transition-colors">Termos de Uso</a></li>
              <li><a href="#" className="hover:text-white transition-colors">Suporte</a></li>
            </ul>
          </div>
        </div>

        <div className="border-t border-gray-800 mt-10 pt-6 flex flex-col sm:flex-row items-center justify-between gap-2 text-xs text-gray-500">
          <span>© {new Date().getFullYear()} Verificamed. Todos os direitos reservados.</span>
          <span>Documentos com validade jurídica conforme Lei 14.063/2020</span>
        </div>
      </div>
    </footer>
  )
}
