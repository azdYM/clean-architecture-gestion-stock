import { Icon } from "./Icon";
import { displayPopup } from "/functions/popup";

export const TopBarNotificationButton = () =>
{
    /**
     * 
     * @param {Event} e 
     */
    const handleDisplayPopup = function (e) {
        e.stopPropagation()
        const position = e.currentTarget.getBoundingClientRect().left
        
        // Definir quelle type de pop up afficher
        // Definir la position où il doit s'afficher 
        // Afficher le pop up
        displayPopup(position, 'notification', 500)        
    }

    return (
        <gcrdt-topbar-notifications-renderer onClick={handleDisplayPopup}  class="gcrdt-topbar-notification">
            <span className="notification-count">9</span>
            <Icon name={"notification"} size={80} />
        </gcrdt-topbar-notifications-renderer>
    )
}