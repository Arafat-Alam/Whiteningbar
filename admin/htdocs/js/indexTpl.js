// function abbreviateNumber(arr) {
//             var newArr = [];
//             $.each(arr, function (index, value) {
//                 var newValue = value;
//                 if (value >= 1000) {
//                     var suffixes = [" ", " K", " mil", " bil", " t"];
//                     var suffixNum = Math.floor(("" + value).length / 3);
//                     var shortValue = '';
//                     for (var precision = 2; precision >= 1; precision--) {
//                         shortValue = parseFloat((suffixNum != 0 ? (value / Math.pow(1000, suffixNum) ) : value).toPrecision(precision));
//                         var dotLessShortValue = (shortValue + '').replace(/[^a-zA-Z 0-9]+/g, '');
//                         if (dotLessShortValue.length <= 2) {
//                             break;
//                         }
//                     }
//                     if (shortValue % 1 != 0)  shortNum = shortValue.toFixed(1);
//                     newValue = shortValue + suffixes[suffixNum];
//                 }
//                 newArr[index] = newValue;
//             });
//             return newArr;
//         }

//         var labels = ["表参道原宿店", "渋谷道玄坂店", "池袋東口店", "大宮店", "柏店", "心斎橋オーパ店", "A広島八丁堀店", "守谷店", "仙台店", "福岡天神ビブレ店"];
//         var values = [278, 218, 206, 167, 151, 159, 140, 134, 127, 121];
//         var outputValues = abbreviateNumber(values);


//         $('.bar-chart').simpleChart({
//             title: {
//                 text: 'asd',
//                 align: 'center'
//             },
//             type: 'bar',
//             layout: {
//                 width: '100%'
//             },
//             item: {
//                 label: labels,
//                 value: values,
//                 outputValue: outputValues,
//                 color: ['#00aeef'],
//                 prefix: '',
//                 suffix: '',
//                 render: {
//                     margin: 0,
//                     size: 'relative'
//                 }
//             }
//         });