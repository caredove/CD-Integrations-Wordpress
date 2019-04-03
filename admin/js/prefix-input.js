/***********************************************
 * #### jQuery Prefix Input v0.01 ####
 * Coded by Ican Bachors 2015.
 * http://ibacor.com/labs/jquery-prefix-input/
 * Updates will be posted to this site.
 ***********************************************/

$.fn.prefix = function(prefix) {

     $(this).on('focus', function() {
        var a = prefix.toString(),
            ibacor_currentId = $(this).attr('id'),
            ibacor_val = $(this).val();
        if (ibacor_val == '') {
            $(this).val(a)
        }
        ibacor_fi(a.replace('ibacorat', ''), ibacor_currentId);
        return false
    });

    function ibacor_fi(d, e) {
        $('#' + e).keydown(function(c) {
            setTimeout(function() {
                var a = bcr_riplis($('#' + e).val()),
                    qq = bcr_riplis(d),
                    ibacor_jumlah = qq.length,
                    ibacor_cek = a.substring(0, ibacor_jumlah);
                if (a.match(new RegExp(qq)) && ibacor_cek == qq) {
                    $('#' + e).val(bcr_unriplis(a))
                } else {
                    if (c.key == 'Control' || c.key == 'Backspace' || c.key == 'Del') {
                        $('#' + e).val(bcr_unriplis(qq))
                    } else {
                        var b = bcr_unriplis(qq) + c.key;
                        $('#' + e).val(b.replace("undefined", ""))
                    }
                }
            }, 50)
        })
    }

    function bcr_riplis(a) {
        var f = ['+', '$', '^', '*', '?'];
        var r = ['ibacorat', 'ibacordolar', 'ibacorhalis', 'ibacorkali', 'ibacortanya'];
        $.each(f, function(i, v) {
            a = a.replace(f[i], r[i])
        });
        return a
    }

    function bcr_unriplis(a) {
        var f = ['+', '$', '^', '*', '?'];
        var r = ['ibacorat', 'ibacordolar', 'ibacorhalis', 'ibacorkali', 'ibacortanya'];
        $.each(f, function(i, v) {
            a = a.replace(r[i], f[i])
        });
        return a
    }

  //   $(this).each(function(i, a) {
  //       $(this).on('focus', function() {
  //           var b = prefix.toString(),
  //               c = $(this).attr('class'),
  //               d = $(this).val();
  //           if (d == '') {
  //               $(this).val(b)
  //           }
  //           pasang(b.replace('ibacorat', ''), c, i);
  //           return false
  //       });
  //       $(this).on('keyup', function() {
  //           var b = prefix.toString(),
  //               c = $(this).attr('class'),
  //               d = $(this).val();
  //           if (d == '') {
  //               $(this).val(b)
  //           }
  //           pasang(b.replace('ibacorat', ''), c, i);
  //           return false
  //       });
  //   });

  //   function pasang(a, b, c) {
  //       $('.' + b).eq(c).keydown(function(d) {
  //           setTimeout(function() {
  //               var e = rubah($('.' + b).eq(c).val(), true),
  //                   f = rubah(a, true),
  //                   g = f.length,
  //                   h = e.substring(0, g);
  //               if (e.match(new RegExp(f)) && h == f) {
  //                   $('.' + b).eq(c).val(rubah(e, false))
  //               } else {
  //                   if (d.key == 'Control' || d.key == 'Backspace' || d.key == 'Del') {
  //                       $('.' + b).eq(c).val(rubah(f, false))
  //                   } else {
  //                       var i = rubah(f, false) + d.key;
  //                       $('.' + b).eq(c).val(i.replace("undefined", ""))
  //                   }
  //               }
  //           }, 50)
  //       })
  //   }

  //   function rubah(a, b) {
  //       var c = ['+', '$', '^', '*', '?'];
  //       var d = ['ibacorat', 'ibacordolar', 'ibacorhalis', 'ibacorkali', 'ibacortanya'];
  //       $.each(c, function(i, v) {
  //           if (b == true) {
  //               a = a.replace(c[i], d[i]);
  //           } else {
  //               a = a.replace(d[i], c[i]);
  //           }
  //       });
  //       return a
  //   }

}

