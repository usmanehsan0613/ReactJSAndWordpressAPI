"use strict";

let baseurl    = 'http://localhost/zupress/open-data/wp-json/wp/v2/';
let customBase = 'http://localhost/zupress/open-data/wp-json/';

const constants = 
{
    ccustomBase : 'https://allt-uae.zu.ac.ae/www-zu/open-data/wp-json/'  , 
    metaUpdate  : "https://allt-uae.zu.ac.ae/www-zu/open-data/wp-json/zutheme/v1/update-posts-meta",
    generalData : "https://allt-uae.zu.ac.ae/www-zu/open-data/wp-json/zutheme/v1/latest-posts/",
    comments    : "https://allt-uae.zu.ac.ae/www-zu/open-data/wp-json/wp/v2/comments",
    username    : "opendataadmin",
    password    : "opendataadmin",
    author_name : "open-data",
    author_email : "open.data@gmail.com",
    assetsURL    : "https://www.zu.ac.ae/main/en/opendata/",

    TotalFiles   : "اجمالي عدد الملفات",

    toview : "To view the data of Zayed University, please enter the National Open Data Portal through the following link ",
    toview_ar : "للاطلاع على بيانات جـامـعـة زايـــد يرجى الدخول على البوابة الوطنية للبيانات المفتوحة من خلال الرابط التالي",

    bayanatLink : "bayanat.ae",
    bayanatLink_ar : "بيانات.امارات",

    opendataUsagePolicy_en         : "Open Data Usage Policy",
    opendataUsagePolicy_ar      : "سياسة استخدام البيانات المفتوحة",


    howToUseOpenData_en         : "How to use Open Data",
    howToUseOpenData_ar         : "كيفية إستخدام البيانات",

    openDataDictionary_ar       : "قاموس البيانات",
    openDataDictionary_en       : "Open Data Dictionary",

    downloadDataSets_en            : "Download Datasets",
    downloadDataSets_ar            : "تحميل مجموعات البيانات",

    beAware_en : "Please be aware that this process may take some time to collect  Files, compress and download them in one file.",
    beAware_ar : "يرجى العلم ان هذه العملية قد تاخذ بعض الوقت لجمع الملفات وضغطها وتحميلها بملف واحد",

    totalNumberFiles_en : "Total Files Number ",
    totalNumberFiles_ar : "اجمالي عدد الملفات",

    dateCreated_ar : "العام الدراسي",
    dateCreated_en : "Date Created",

    success_en : "Successfully posted",
    success_ar : "تم التقييم بنجاح",

    errorComment_en : "Error posting comments",
    errorComment_ar : "عذراً لقمت قمت بالتقييم مسبقاً",

    placeHolder_ar  : "رأيك يهمنا",
    placeHolder_en  : "Post your comments",

 };

const url = "data:url";

export default constants;