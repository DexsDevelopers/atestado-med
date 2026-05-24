import { useState } from 'react'
import { Link, useLocation } from 'react-router-dom'
import { Menu, X, Stethoscope } from 'lucide-react'

const navLinks = [
  { to: '/', label: 'Início' },
  { to: '/atestado', label: 'Atestado' },
  { to: '/receita', label: 'Receita' },
  { to: '/verificar', label: 'Verificar Documento' },
]

export default function Navbar() {
  const [open, setOpen] = useState(false)
  const location = useLocation()

  return (
    <header className="sticky top-0 z-50 bg-white border-b border-gray-100 shadow-sm">
      <div className="max-w-6xl mx-auto px-4 sm:px-6 flex items-center justify-between h-16">
        <Link to="/" className="flex items-center gap-2 font-bold text-xl text-primary-700">
          <div className="w-8 h-8 rounded-lg gradient-bg flex items-center justify-center">
            <Stethoscope className="w-4 h-4 text-white" />
          </div>
          Verificamed
        </Link>

        <nav className="hidden md:flex items-center gap-1">
          {navLinks.map(link => (
            <Link
              key={link.to}
              to={link.to}
              className={`px-4 py-2 rounded-lg text-sm font-medium transition-colors ${
                location.pathname === link.to
                  ? 'bg-primary-50 text-primary-700'
                  : 'text-gray-600 hover:text-primary-700 hover:bg-gray-50'
              }`}
            >
              {link.label}
            </Link>
          ))}
        </nav>

        <div className="hidden md:flex items-center gap-3">
          <Link
            to="/verificar"
            className="px-4 py-2 text-sm font-semibold text-white rounded-lg gradient-bg hover:opacity-90 transition-opacity"
          >
            Verificar Agora
          </Link>
        </div>

        <button
          className="md:hidden p-2 rounded-lg text-gray-600 hover:bg-gray-100"
          onClick={() => setOpen(!open)}
        >
          {open ? <X className="w-5 h-5" /> : <Menu className="w-5 h-5" />}
        </button>
      </div>

      {open && (
        <div className="md:hidden border-t border-gray-100 bg-white px-4 py-3 flex flex-col gap-1">
          {navLinks.map(link => (
            <Link
              key={link.to}
              to={link.to}
              onClick={() => setOpen(false)}
              className={`px-4 py-3 rounded-lg text-sm font-medium transition-colors ${
                location.pathname === link.to
                  ? 'bg-primary-50 text-primary-700'
                  : 'text-gray-700 hover:bg-gray-50'
              }`}
            >
              {link.label}
            </Link>
          ))}
        </div>
      )}
    </header>
  )
}
