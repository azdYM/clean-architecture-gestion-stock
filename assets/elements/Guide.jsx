import { Icon } from "/components/Icon"
import { $ } from "/functions/dom"
import { getUserActions, routes } from "/functions/links"
import { substring } from "/functions/string"
import { Link } from 'react-router-dom'

export const RendererGuideContent = () => {
    return (
        <gck-guide-renderer id="guide-content">
            <RenderSections />
        </gck-guide-renderer>
    )    
}

function RenderSections()
{
    return (
        <div className="sections">
            <RenderBaseSection />
        </div>
    )
}

function RenderBaseSection() 
{
    const userRoles = [
        {key: 'ROLE_GAGE_EVALUATOR', value: 'Evaluateur de gage'},
        {key: 'ROLE_GAGE_SUPERVISOR', value: 'Superviseur de gage'}
    ]

    return (
        <>
            <gck-guide-section-renderer>
                <RenderBaseLinks />
                <RenderCustomLinks roles={userRoles} />
            </gck-guide-section-renderer>
        </>
    )
}

function RenderBaseLinks()
{
    const links = [
        {label: 'Acceuil', path: routes.home, icon: 'home'},
        {label: 'Historique', path: routes.history, icon: 'history'}
    ]

    return (
        <>
            {links.map((link, index) => (
                <mck-guide-entry-renderer key={index}>
                    <LinkWrapper label={link.label} path={link.path} icon={link.icon} />
                </mck-guide-entry-renderer>
            ))}
        </>
    )
}   

function RenderCustomLinks({roles})
{
    return (
        <>
            {roles.map((role, index) => (
                <mck-guide-collaps-entry-rendering key={index}>
                    <RenderLinksForRole role={role} />
                </mck-guide-collaps-entry-rendering>
            ))}
        </>
    )
}

function RenderLinksForRole({role})
{
    const links = getUserActions(role.key)

    return (
        <>
            {links.map((action, index) => <RenderLink key={index} action={action} />)}
        </>
    )
}

function RenderLink({action})
{
    return (
        <mck-guide-entry-renderer>
            <LinkWrapper label={substring(action.label, 20)} path={action.path} icon={action.icon} />
        </mck-guide-entry-renderer>
    )
}

function LinkWrapper({label, icon, path, className=''})
{
    const handleClick = (e) => {
        const classNameWhenClicked = 'clicked';
        $(`.${classNameWhenClicked}`, $('#guide-content', document))?.classList.remove(classNameWhenClicked)
        e.currentTarget.classList.add(classNameWhenClicked)
    }

    return (
        <Link onClick={handleClick} className={`link-menu ${className}`} to={path}>
            <Icon className="link-icon" size={80} name={icon} />
            <span className="link-label">{label}</span>
        </Link>
    )
}