let num="1234 5678";
let re = /([0-9]{1,4})\s([0-9]{1,4})/;
//let re = /(\d+)?(\d{3})/;
    re.test(num);
    let ejemplo =  num.replace(re, "$2$1");

    console.log(ejemplo);

    let ejemplo2 = num.replace(re,function( item, itm ){
        let numero = item.replace(re,'$2');
        // console.log("Este es el return: ",numero);
        return item;
    });

    console.log("exec: ", re.exec(num)  );

