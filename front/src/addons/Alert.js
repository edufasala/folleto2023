import { Notify } from 'quasar'
export class Alert {
  static success (message) {
    Notify.create({
      message,
      color: 'positive',
      icon: 'check_circle',
      position: 'top',
      actions: [{ icon: 'close', color: 'white' }]
    })
  }

  static error (message) {
    Notify.create({
      message,
      color: 'negative',
      icon: 'error',
      position: 'top',
      actions: [{ icon: 'close', color: 'white' }]
    })
  }
}
