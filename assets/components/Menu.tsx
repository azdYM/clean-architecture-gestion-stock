import { Avatar } from "./Avatar"
import { Icon } from "./Icon"
import { substring } from "../functions/string"

export type UserType = {
    fullname: string,
    email: string,
    roles: RoleUser[],
    agency: string|null,
    section: string|null
}

type RoleUser = {
    key: string,
    value: string
}

export const RenderHeaderMenu = () =>
{
    const user: UserType = {
        fullname: 'Abdoul-wahid Hassani', 
        email: 'abdoul-wahid_hassani@meck-moroni.org',
        roles: [{key: 'ROLE_EVALUTOR_GAGE', value: 'Evaluateur de gage'}],
        agency: 'Meck-Moroni Volo-volo',
        section: 'Evaluation gage'
    }

    return (
        <div className='popup-header header-menu'>
            <div className="about-user-profile"> 
                <Avatar user={{fullname: 'Imamou Mina'}}/>
                <AboutUserProfile user={user} />
            </div>
            <AboutUserProfession user={user} />
        </div>
    )
}

export const RenderContentMenu = () =>
{
    const links = 
    [
        {path: '/logout', label: 'Se déconnecter', icon: 'logout'},
        {path: '#', label: 'Gérer mon compte', icon: 'user-circle-gear'},
        {path: '#', label: 'Apparence : thème claire', icon: 'theme'},
        {path: '#', label: 'Paramètres', icon: 'settings'}
    ]

    return (
        <div className="popup-content content-menu">
            {links.map((link, i) => <LinkMenu key={i} label={link.label} path={link.path} icon={link.icon} />)}
        </div>
    )
}

/** =============== Composant liée au header ============= */

const AboutUserProfile = function({user}: {user: UserType}) 
{
    return (
        <div className='about-profile'>
            <span>{substring(user.fullname, 30)}</span>
            <span className="email">{substring(user.email, 40)}</span>
        </div>
    )
}

const AboutUserProfession = function({user}: {user: UserType}) 
{
    return (
        <div className='about-profession'>
            {user.roles.map((role, index) => <ShowUserFunction key={index} role={role} user={user}/>)}
        </div>
    )
}

const ShowUserFunction = function({role, user}: {role: RoleUser, user: UserType})
{
    const agentRoles = 
    [
        'ROLE_AGENT_CREDIT',
        'ROLE_EVALUTOR_GAGE',
        'ROLE_GAGE_SUPERVISOR',
        'ROLE_CREDIT_SUPERVISOR'
    ]

    if (agentRoles.includes(role.key)) {
        return <ShowAgentInformationAboutWork role={role} user={user} />
    }

    switch (role.key) {
        case 'ROLE_AGENCY_MANAGER':
            return <ShowAgencyManagerInforamtionAboutWork role={role} user={user} />
        case 'ROLE_MANAGER':
            return <ShowManagerInformationAboutWork role={role} />
        default:
            break;
    }
}

const ShowAgentInformationAboutWork = function({role, user}: {role: RoleUser, user: UserType})
{
    return (
        <div className="fonction-agent">
            <div className="fonction-item">
                <span>Agence</span>
                <span>{user.agency}</span>
            </div>
            <div className="fonction-item">
                <span>Section</span>
                <span>{user.section}</span>
            </div>
            <div className="fonction-item">
                <span>Fonction</span>
                <span>{role.value}</span>
            </div>
        </div>
    )
}

const ShowAgencyManagerInforamtionAboutWork = function({role, user}: {role: RoleUser, user: UserType})
{
    return (
        <div className="fonction">
            <div className="fonction-item">
                <span>Agence</span>
                <span>{user.agency}</span>
            </div>
            <div className="fonction-item">
                <span>Fonction</span>
                <span>{role.value}</span>
            </div>
        </div>
    )
}

const ShowManagerInformationAboutWork = function({role}: {role: RoleUser})
{
    return (
        <div className="fonction">
            <div className="fonction-item">
                <span>Fonction</span>
                <span>{role.value}</span>
            </div>
        </div>
    )
}

/** =============== Composant liée au contenu ============= */

export function LinkMenu({label, icon, path, className}: {label: string, icon: string, path: string, className?: string})
{
    return (
        <a href={path} className={`link-menu ${className}`}>
            <Icon className="link-icon" size={80} name={icon} />
            <span className="link-label">{label}</span>
        </a>
    )
}