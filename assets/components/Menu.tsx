import { Avatar } from "./Avatar"
import { Icon } from "./Icon"
import { substring } from "../functions/string"
import { RoleUser, UserData, getUserRole } from "../api/user"
import { useCustomContext } from "../functions/hooks"
import { UserContext } from "../functions/context"

type ShowAgentInformationAboutWorkProps = {
	role: keyof typeof RoleUser, 
	user: UserData
}

/** =============== Composant liée au header ============= */

export const RenderHeaderMenu = () =>
{
    const user = useCustomContext(UserContext)
    if (!user) return
	console.log(user, "user")
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

const AboutUserProfile = function({user}: {user: UserData}) 
{
    return (
        <div className='about-profile'>
            <span>{substring(user.fullname, 30)}</span>
            <span className="email">{substring(user.email, 40)}</span>
        </div>
    )
}

const AboutUserProfession = function({user}: {user: UserData}) 
{
    return (
        <div className='about-profession'>
            {user.roles.map((role, index) => 
				<ShowUserFunction key={index} role={role} user={user}/>
			)}
        </div>
    )
}

const ShowUserFunction = function({role, user}: ShowAgentInformationAboutWorkProps)
{
    if (user.roles.includes(role)) {
        return <ShowAgentInformationAboutWork role={role} user={user} />
    }

    switch (role) {
        case 'ROLE_AGENCY_MANAGER':
            return <ShowAgencyManagerInforamtionAboutWork 
				role={role} 
				user={user} 
			/>
        case 'ROLE_CREDIT_MANAGER':
            return <ShowManagerInformationAboutWork role={role} />
        default:
            break;
    }
}

const ShowAgentInformationAboutWork = function({role, user}: ShowAgentInformationAboutWorkProps)
{
	const workAgencyName = user.agency?.label ?? 'Associé à aucune agence'
	const workSectionName = user.workingService ?? 'Associé à aucune section'

    return (
        <div className="fonction-agent">
            <div className="fonction-item">
                <span>Agence</span>
                <span>{workAgencyName}</span>
            </div>
            <div className="fonction-item">
                <span>Section</span>
                <span>{workSectionName}</span>
            </div>
            <div className="fonction-item">
                <span>Fonction</span>
                <span>{getUserRole(role).value}</span>
            </div>
        </div>
    )
}

const ShowAgencyManagerInforamtionAboutWork = function({role, user}: ShowAgentInformationAboutWorkProps)
{
	const workAgencyName = user.agency?.label ?? 'Associé à aucune agence'

    return (
        <div className="fonction">
            <div className="fonction-item">
                <span>Agence</span>
                <span>{workAgencyName}</span>
            </div>
            <div className="fonction-item">
                <span>Fonction</span>
                <span>{getUserRole(role).value}</span>
            </div>
        </div>
    )
}

const ShowManagerInformationAboutWork = function({role}: {role: keyof typeof RoleUser})
{
    return (
        <div className="fonction">
            <div className="fonction-item">
                <span>Fonction</span>
                <span>{getUserRole(role).value}</span>
            </div>
        </div>
    )
}

/** =============== Composant liée au contenu ============= */

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

export function LinkMenu({label, icon, path, className}: {label: string, icon: string, path: string, className?: string})
{
    return (
        <a href={path} className={`link-menu ${className}`}>
            <Icon className="link-icon" size={80} name={icon} />
            <span className="link-label">{label}</span>
        </a>
    )
}