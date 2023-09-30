// import QRCode from 'qrcode'
// import { useCounterStore } from 'stores/example-store'
// import { Printd } from 'printd'
// import conversor from 'conversor-numero-a-letras-es-ar'
import { jsPDF } from 'jspdf'
// import $ from "jquery";
// import moment from 'moment'
export class Reportes {
  static tesoreriaReport (pagos, fechaDesde, fechaHasta) {
    // const cm = this
    /* eslint-disable */
    const doc = new jsPDF('p', 'mm', 'letter')
    doc.setFontSize(10)
    doc.setFont('helvetica')
    doc.addFont("fonts/DancingScript-VariableFont_wght.ttf", "Dancing", "normal");
    doc.addFont("fonts/DancingScript-Bold.ttf", "Dancing", "bold");
    doc.addFont("fonts/Belanosima-Regular.ttf", "Belanosima", "normal");
    doc.addFont("fonts/Belanosima-Bold.ttf", "Belanosima", "bold");
    doc.addFont("fonts/Poppins-Regular.ttf", "Poppins", "normal");
    doc.addFont("fonts/Poppins-Bold.ttf", "Poppins", "bold");

    this.textoJsPdf(doc, 'IMPRENTA FOLLETO', 'Dancing', 'bold', 15, [0,0,0], 10, 10, 'left')

    this.textoJsPdf(doc, 'Av. 6 de Agosto Nro. 2460', 'Poppins', 'normal', 8, [0,0,0], 10, 15, 'left')
    this.textoJsPdf(doc, 'La Paz - Bolivia', 'Poppins', 'normal', 8, [0,0,0], 10, 20, 'left')
    this.textoJsPdf(doc, 'Teléfono: 244 5454', 'Poppins', 'normal', 8, [0,0,0], 10, 25, 'left')

    this.textoJsPdf(doc, `del ${fechaDesde} al ${fechaHasta}`, 'Poppins', 'normal', 10, [0,0,0], 110, 30, 'center')
    pagos.forEach(( pago, index) =>{
      this.textoJsPdf(doc, pago.fecha, 'Poppins', 'normal', 9, [0,0,0], 10, 45 + ((index+1) * 5), 'left')
      this.textoJsPdf(doc, pago.dni, 'Poppins', 'normal', 9, [0,0,0], 30, 45 + ((index+1) * 5), 'left')
      this.textoJsPdf(doc, pago.nombre, 'Poppins', 'normal', 9, [0,0,0], 50, 45 + ((index+1) * 5), 'left')
      this.textoJsPdf(doc, pago.id+'', 'Poppins', 'normal', 9, [0,0,0], 100, 45 + ((index+1) * 5), 'left')
      this.textoJsPdf(doc, pago.metodoPago, 'Poppins', 'normal', 9, [0,0,0], 120, 45 + ((index+1) * 5), 'left')
      this.textoJsPdf(doc, pago.tipo, 'Poppins', 'normal', 9, [0,0,0], 150, 45 + ((index+1) * 5), 'left')
      this.textoJsPdf(doc, pago.monto+'', 'Poppins', 'normal', 9, [0,0,0], 170, 45 + ((index+1) * 5), 'left')
      this.textoJsPdf(doc, pago.estado, 'Poppins', 'normal', 9, [0,0,0], 190, 45 + ((index+1) * 5), 'left')

    })
    doc.rect(110, 5, 100, 10, 'F')
    doc.rect(10, 33, 200, 10, 'F')

    this.textoJsPdf(doc, 'REPORTE DE TESORERIA', 'Poppins', 'bold', 12, [255,255,255], 160, 11, 'center')
    this.textoJsPdf(doc, 'Fecha', 'Poppins', 'bold', 10, [255,255,255], 11, 40, 'left')
    this.textoJsPdf(doc, 'N° CI', 'Poppins', 'bold', 10, [255,255,255], 30, 40, 'left')
    this.textoJsPdf(doc, 'Nombre', 'Poppins', 'bold', 10, [255,255,255], 50, 40, 'left')
    this.textoJsPdf(doc, 'N Pedido', 'Poppins', 'bold', 10, [255,255,255], 100, 40, 'left')
    this.textoJsPdf(doc, 'Producto', 'Poppins', 'bold', 10, [255,255,255], 120, 40, 'left')
    this.textoJsPdf(doc, 'Tipo', 'Poppins', 'bold', 10, [255,255,255], 150, 40, 'left')
    this.textoJsPdf(doc, 'Monto', 'Poppins', 'bold', 10, [255,255,255], 170, 40, 'left')
    this.textoJsPdf(doc, 'Estado', 'Poppins', 'bold', 10, [255,255,255], 190, 40, 'left')
    doc.save('reporte.pdf')
    // $('#ifmcontentstoprint').attr('src', doc.output('datauristring'))
  }
  static textoJsPdf (doc, text, font,normal,size,color, x, y, center) {
    doc.setFont(font, normal)
    doc.setFontSize(size)
    doc.setTextColor(color[0], color[1], color[2]);
    doc.text(text, x, y, null, null, center)
  }
}
