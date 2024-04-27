export const formatNumber = function(number: number) {
    const numberFormat = new Intl.NumberFormat("fr-FR")
    return numberFormat.format(number)
}

// je sais que ce truc est horrible, je compte bien le clean ou utilisé une librairie pour ça
// mais bon pour l'instant, je vais me contenter de cette merde
export const formatRelativeDate = function(date: Date): string {
  const now = new Date();
  const diffInSeconds = Math.floor((now.getTime() - date.getTime()) / 1000);

  // On a une date du future
  if (diffInSeconds < 0) {
    if (- diffInSeconds < 60) {
      return `Dans ${diffInSeconds} s`;
    } 
    
    else if (- diffInSeconds < 3600) {
      const diffInMinutes = Math.floor(diffInSeconds / 60);
      return `Dans ${diffInMinutes} min`;
    } 
    
    else if (- diffInSeconds < 86400) {
      const diffInHours = Math.floor(diffInSeconds / 3600);
      return `Dans ${diffInHours}h`;
      
    } 
    
    // on a peut être une date du passé ou du future
    else {
      const day = date.getDate();
      const month = date.getMonth() + 1;
      const year = date.getFullYear();
      return `Le ${day}/${month}/${year}`;
    }
  }

  // on a une date du passé
  if (diffInSeconds < 60) {
    return `Il y a ${diffInSeconds} s`;
  } 
  
  else if (diffInSeconds < 3600) {
    const diffInMinutes = Math.floor(diffInSeconds / 60);
    return `Il y a ${diffInMinutes} min`;
  } 
  
  else if (diffInSeconds < 86400) {
    const diffInHours = Math.floor(diffInSeconds / 3600);
    return `il y a ${diffInHours}h`;
    
  } 
  
  else {
    const day = date.getDate();
    const month = date.getMonth() + 1;
    const year = date.getFullYear();
    return `Le ${day}/${month}/${year}`;
  }
}

export const formatDate = (dateString: string): string => {
  const date = new Date(dateString)
  const today = new Date()
  const yesterday = new Date(today)
  yesterday.setDate(today.getDate() - 1)
  const lastWeek = new Date(today)
  lastWeek.setDate(today.getDate() - 7)

  if (date.toDateString() === today.toDateString()) {
    return "Aujourd'hui"
  } 
  
  else if (date.toDateString() === yesterday.toDateString()) {
    return 'Hier'
  } 
  
  else if (date > lastWeek) {
    // Si la date est dans la semaine dernière
    const daysAgo = Math.floor((today.getTime() - date.getTime()) / (24 * 3600 * 1000))
    return `Il y a ${daysAgo} jours`
  } 
  
  else {
    // Sinon, affiche au format YYYY-MM-DD
    const year = date.getFullYear()
    const month = `0${date.getMonth() + 1}`.slice(-2)
    const day = `0${date.getDate()}`.slice(-2)
    return `${year}-${month}-${day}`
  }
}