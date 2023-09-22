export const routes = {
    home: '/',
    history: '/historique',
    addCustomer: '/ajouter-client',
    showCustomer: '/client/:id',
    evaluateGage: '/evaluer-gage',
    showGage: '/gage/:id',
    checkAttestations: '/chack-attestations',
    showAttestation: '/attestation/:id'
}

const userActions = [
    {
        role: 'ROLE_AGENCY_MANAGER',
        links: [
            {path: '#', label: "", icon: ""}
        ]
    },
    {
        role: 'ROLE_GAGE_MANAGER',
        links: [
            
        ]
    },
    {
        role: 'ROLE_CREDIT_MANAGER',
        links: [
    
        ]
    },
    {
        role: 'ROLE_CREDIT_SUPERVISOR',
        links: [
            
        ]
    },
    {
        role: 'ROLE_CREDIT_AGENT',
        links: [
    
        ]
    },
    {
        role: 'ROLE_GAGE_EVALUATOR',
        links: [
            {path: routes.addCustomer, label: "Ajouter un client", icon: "user-add"},
            {path: routes.evaluateGage, label: "Evaluer un gage", icon: "evaluation"},
        ]
    },
    {
        role: 'ROLE_GAGE_SUPERVISOR',
        links: [
            {path: routes.checkAttestations, label: "Check attestations", icon: "check"},
            {path: routes.showAttestation, label: "Attestations", icon: "certificate"},

        ]
    }
]

export const getUserActions = (userRole) => {
    const action = userActions.filter(action => action.role === userRole)
    return action[0].links
}
