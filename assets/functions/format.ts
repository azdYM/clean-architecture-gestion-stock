export const formatNumber = function(number: number) {
    const numberFormat = new Intl.NumberFormat("fr-FR")
    return numberFormat.format(number)
}

export const formatRelativeDate = function(date: Date): string {
    const now = new Date();
    const diffInSeconds = Math.floor((now.getTime() - date.getTime()) / 1000);
  
    if (diffInSeconds < 60) {
      return `Il y a ${diffInSeconds} s`;
    } else if (diffInSeconds < 3600) {
      const diffInMinutes = Math.floor(diffInSeconds / 60);
      return `Il y a ${diffInMinutes} min`;
    } else if (diffInSeconds < 86400) {
      const diffInHours = Math.floor(diffInSeconds / 3600);
      return `il y a ${diffInHours}h`;
    } else {
      // Utiliser votre propre logique pour afficher la date complète
      const day = date.getDate();
      const month = date.getMonth() + 1;
      const year = date.getFullYear();
      return `${day}/${month}/${year}`;
    }
  };