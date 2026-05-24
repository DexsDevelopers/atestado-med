import { BrowserRouter, Routes, Route } from 'react-router-dom'
import Navbar from './components/Navbar'
import Footer from './components/Footer'
import Home from './pages/Home'
import Atestado from './pages/Atestado'
import Receita from './pages/Receita'
import Verificar from './pages/Verificar'

export default function App() {
  return (
    <BrowserRouter>
      <div className="min-h-screen flex flex-col">
        <Navbar />
        <main className="flex-1">
          <Routes>
            <Route path="/" element={<Home />} />
            <Route path="/atestado" element={<Atestado />} />
            <Route path="/receita" element={<Receita />} />
            <Route path="/verificar" element={<Verificar />} />
          </Routes>
        </main>
        <Footer />
      </div>
    </BrowserRouter>
  )
}
