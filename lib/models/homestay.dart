class Homestay {
  String? homestayId;
  String? userId;
  String? homestayName;
  String? homestayDesc;
  String? homestayPrice;
  String? homestayMealprice;
  String? noRoom;
  String? homestayState;
  String? homestayLocal;
  String? homestayLat;
  String? homestayDate;

  Homestay(
      {this.homestayId,
      this.userId,
      this.homestayName,
      this.homestayDesc,
      this.homestayPrice,
      this.homestayMealprice,
      this.noRoom,
      this.homestayState,
      this.homestayLocal,
      this.homestayLat,
      this.homestayDate});

  Homestay.fromJson(Map<String, dynamic> json) {
    homestayId = json['homestay_id'];
    userId = json['user_id'];
    homestayName = json['homestay_name'];
    homestayDesc = json['homestay_desc'];
    homestayPrice = json['homestay_price'];
    homestayMealprice = json['homestay_mealprice'];
    noRoom = json['no_room'];
    homestayState = json['homestay_state'];
    homestayLocal = json['homestay_local'];
    homestayLat = json['homestay_lat'];
    homestayDate = json['homestay_date'];
  }

  Map<String, dynamic> toJson() {
    final Map<String, dynamic> data = <String, dynamic>{};
    data['product_id'] = homestayId;
    data['user_id'] = userId;
    data['product_name'] = homestayName;
    data['product_desc'] = homestayDesc;
    data['product_price'] = homestayPrice;
    data['product_delivery'] = homestayMealprice;
    data['product_qty'] = noRoom;
    data['product_state'] = homestayState;
    data['product_local'] = homestayLocal;
    data['product_lat'] = homestayLat;
    data['product_date'] = homestayDate;
    return data;
  }
}