export const routes = {
    home: '/',
    history: '/history',
    addCustomer: '/add-client',
    showCustomer: '/client/:id',
    evaluateGage: '/evaluation',
    showGage: '/evaluation/:id',
    attestations: '/attestations',
    showAttestation: '/attestation/:id',
    createCredit: 'add-credit',
    showCredit: 'credit/:id',
    credits: '/credits',

    allAttestations: '/',
    rejectedAttestations: 'rejected',
    acceptedAttestations: 'accepted'
    
}

export type LinksType = {path: string; label: string; icon: string}
export type UserRolesType = {key: string; value: string}

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

export const getUserActions = (userRole: string) => {
    const action = userActions.filter(action => action.role === userRole)
    return action[0].links
}
