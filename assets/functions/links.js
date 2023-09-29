export const routes = {
    home: '/',
    history: '/history',
    addCustomer: '/add-client',
    showCustomer: '/client/:id',
    evaluateGage: '/evaluate-gold',
    showGage: '/gold-attestation/:id',
    attestations: '/attestations',
    showAttestation: '/attestation/:id',
    createCredit: 'add-credit',
    showCredit: 'credit/:id',
    credits: '/credits',
    showCredit: '/credit/:id',

    allAttestations: '/',
    rejectedAttestations: 'rejected',
    acceptedAttestations: 'accepted'
    
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
            // {path: routes.addCustomer, label: "Ajouter un client", icon: "user-add"},
            {path: routes.createCredit, label: "Créer un crédit", icon: "create-credit"},
        ]
    },
    {
        role: 'ROLE_GAGE_EVALUATOR',
        links: [
            {path: routes.addCustomer, label: "Ajouter un client", icon: "user-add"},
            {path: routes.evaluateGage, label: "Evaluer un gage", icon: "create-gage"},
        ]
    },
    {
        role: 'ROLE_GAGE_SUPERVISOR',
        links: [
            // {path: routes.checkAttestations, label: "Check attestations", icon: "check"},
            // {path: routes.showAttestation, label: "Attestation", icon: "certificate"},
        ]
    }
]

export const getUserActions = (userRole) => {
    const action = userActions.filter(action => action.role === userRole)
    return action[0].links
}
