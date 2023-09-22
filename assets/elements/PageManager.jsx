import { Routes, Route } from 'react-router-dom'
import { Home } from '/components/Home'
import { AddCustomer } from '/components/AddCustomer'
import { ShowCustomer } from '/components/ShowCustomer'
import { EvaluateGage } from '/components/EvaluateGage'
import { ShowGage } from '/components/ShowGage'
import { CheckAttestations } from '/components/CheckAttestations'
import { ShowAttestation } from '/components/ShowAttestation'
import { routes } from '/functions/links'
import { History } from '/components/History'

export const PageManager = () => {
    return (
        <Routes>
            <Route path={routes.home} element={<Home />} />
            <Route path={routes.history} element={<History />} />
            <Route path={routes.addCustomer} element={<AddCustomer />} />
            <Route path={routes.showCustomer} element={<ShowCustomer />} />
            <Route path={routes.evaluateGage} element={<EvaluateGage />} />
            <Route path={routes.showGage} element={<ShowGage />} />
            <Route path={routes.checkAttestations} element={<CheckAttestations />} />
            <Route path={routes.showAttestation} element={<ShowAttestation />} />
        </Routes>
    )
}