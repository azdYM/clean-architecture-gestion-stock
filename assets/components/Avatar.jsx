import { getAcronyme } from "/functions/string"

export const Avatar = ({user}) =>
{
    return (
        <div className="avatar">
            {user.avatar ? <img src="" alt="" /> : <span>{getAcronyme(user.fullname ?? 'AZ')}</span>}
        </div>
    )
}