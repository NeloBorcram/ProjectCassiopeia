<?php

class DB {

    private $host = "localhost";
    private $user = "cassiopeiaAdmin";
    private $password = "cassiopeiaPassword";
    private $dbname = "ProjectCassiopeia";
    private $connection = null;

    function connect2DB() {
        $this->connection = new mysqli($this->host, $this->user, $this->password, $this->dbname);
        return $this->connection;
    }

    //TODO: function getAllSensorData()
    //TODO: function insertAllSensorData()
    //TODO: function insertTempAndHum() - insert temperature and humidity into db





    /*EXAMPLE FUNCTIONS OF AN OLD PROJECT FOR REFERENCE PURPOSE ONLY

    function getProduct($productID) {
        $this->connect2DB();

        $query = "SELECT * FROM Product WHERE ProductID =" . $productID;
        $ergebnis = $this->connection->query($query);
        if ($ergebnis) {
            $zeile = $ergebnis->fetch_object();
            $product = new Product($productID, $zeile->CategoryID, $zeile->Name, $zeile->Price, $zeile->Description);
            $this->connection->close();
            return $product;
        }
        $this->connection->close();
        return false;
    }

    function getCategoryAsObjectArray() {
        $category = array();

        $this->connect2DB();
        $query = "Select * from Category";
        $ergebnis = $this->connection->query($query);
        if ($ergebnis) {
            while ($zeile = $ergebnis->fetch_object()) {
                $category[] = new Category($zeile->CategoryID, $zeile->CategoryName);
            }
            $this->connection->close();
            return $category;
            return true;
        } else {
            $this->connection->close();
            return false;
        }
    }

    function updateProduct($product) {
        $con = $this->connect2DB();
        $statement = $con->prepare("UPDATE product SET CategoryID = ?, Name = ? , Price = ? , Description = ? WHERE ProductID = ?");
        $statement->bind_param("isdsi", $product->getCategoryID(), $product->getName(), $product->getPrice(), $product->getDescription(), $product->getProductID());
        $result = $statement->execute();

        if ($result) {
            $this->connection->close();
            return true;
        } else {
            $this->connection->close();
            return false;
        }
    }

    function deleteProduct($productID) {
        $con = $this->connect2DB();
        $statement = $con->prepare("DELETE FROM product WHERE ProductID = ?");
        $statement->bind_param("i", $productID);
        $result = $statement->execute();
        $con->close();
        return ($result) ? true : false;
    }

    function getOneCustomerAsObject($customerID) {
        $con = $this->connect2DB();
        $query = "SELECT * FROM customer WHERE CustomerID = " . $customerID;
        $result = $con->query($query);
        if ($result) {
            $line = $result->fetch_object();
            if ($customerID) {
                $customer = new Customer($customerID, $line->UserID, $line->Anrede, $line->Vorname, $line->Nachname, $line->Adresse, $line->PLZ, $line->Ort, $line->Email, $line->Zahlungsinfo);
                $con->close();
                return $customer;
            }
        }
        $con->close();
        return false;
    }

    function getCustomerID($username) {
        $this->connect2DB();
        $query = "SELECT * FROM user join customer using(UserID) WHERE username='" . $username . "'";
        $ergebnis = $this->connection->query($query);
        if ($ergebnis) {
            $zeile = $ergebnis->fetch_object();
            if (isset($zeile->CustomerID))
                $customerID = $zeile->CustomerID;
            else
                $customerID = false;
            $this->connection->close();
            return $customerID;
        }
        return false;
    }

    function getOrders($customerID) {
        $orders = array(); //leeres array für object array initialisieren
        $this->connect2DB();
        $query = "SELECT * FROM PurchaseOrder WHERE CustomerID = " . $customerID . " ORDER BY 'Date' DESC";
        $ergebnis = $this->connection->query($query);
        if ($ergebnis) {
            while ($zeile = $ergebnis->fetch_object()) {
                $orders[] = new PurchaseOrder($zeile->OrderID, $zeile->CustomerID, $zeile->CouponID, $zeile->Date); //neues PurchaseOrder Object an das object array hinzufügen
            }

            $this->connection->close();
            return $orders;
        }
        $this->connection->close();
        return 0;
    }

    function getCustomer($customerID) {
        $con = $this->connect2DB();
        $query = "SELECT * FROM Customer WHERE CustomerID = " . $customerID;
        $result = $con->query($query);
        if ($result) {
            $line = $result->fetch_object();
            $customer = new Customer($line->CustomerID, $line->UserID, $line->Anrede, $line->Vorname, $line->Nachname, $line->Adresse, $line->PLZ, $line->Ort, $line->Email, $line->Zahlungsinfo);

            $con->close();
            return $customer;
        }
        $con->close();
        return 0;
    }

    function updateCustomer($customer) {
        $con = $this->connect2DB();
        $statement = $con->prepare("UPDATE Customer SET Anrede = ?, Vorname = ? , Nachname = ? , Adresse = ? , PLZ = ? , Ort = ? , Email = ? , Zahlungsinfo= ? WHERE CustomerID = ?");
        $statement->bind_param("ssssisssi", $customer->getAnrede(), $customer->getVorname(), $customer->getNachname(), $customer->getAdresse(), $customer->getPLZ(), $customer->getOrt(), $customer->getEmail(), $customer->getZahlungsinfo(), $customer->getCustomerID());
        $result = $statement->execute();

        if ($result) {
            $con->close();
            return true;
        } else {
            $con->close();
            return false;
        }
    }

    function checkPassword($username, $password) {
        $con = $this->connect2DB();
        $query = "SELECT password FROM user WHERE username='" . $username . "'";
        $result = $con->query($query);
        if ($result) {
            $line = $result->fetch_object();
            if ($line->password == $password) {
                $con->close();
                return true;
            }
        }
        $con->close();
        return false;
    }

    function updatePassword($username, $password) {
        $con = $this->connect2DB();
        $statement = $con->prepare("UPDATE User SET Password = ? WHERE Username = ?");
        $statement->bind_param("ss", $password, $username);
        $result = $statement->execute();

        if ($result) {
            $con->close();
            return true;
        } else {
            $con->close();
            return false;
        }
    }

    function getSearchedProducts($search) {
        $product = array();
        $con = $this->connect2DB();
        $query = "SELECT * FROM Product WHERE Name LIKE '%" . $search . "%'";
        $result = $con->query($query);
        if ($result) {
            while ($line = $result->fetch_object()) {
                $product[] = new Product($line->ProductID, $line->CategoryID, $line->Name, $line->Price, $line->Description);
            }
            $con->close();
            return $product;
        } else {
            $con->close();
            return false;
        }
    }

    function getCategoryAsObject($categoryID) {
        $con = $this->connect2DB();
        $query = "SELECT * FROM Category WHERE CategoryID = " . $categoryID;
        $result = $con->query($query);
        if ($result) {
            $line = $result->fetch_object();
            $category = new Category($line->CategoryID, $line->CategoryName);

            $con->close();
            return $category;
        }
        $con->close();
        return 0;
    }

    function getAllProductAsObjectArray() {
        $con = $this->connect2DB();
        $query = "SELECT * FROM Product";
        $result = $con->query($query);

        if ($result) {
            while ($line = $result->fetch_object()) {
                $product[] = new Product($line->ProductID, $line->CategoryID, $line->Name, $line->Price, $line->Description);
            }
            $con->close();
            return $product;
        }
        $con->close();
        return null;
    }

    function checkUsername($username) {
        $con = $this->connect2DB();
        $query = "SELECT * FROM User WHERE Username = " . $username;
        $result = $con->query($query);
        if ($result) {
            $line = $result->fetch_object();
            $existingUser = $line->Username;

            $con->close();
            if ($existingUser)
                return true;
        }
        $con->close();
        return false;
    }

    function updateCoupon($couponID, $couponRestValue) {
        $con = $this->connect2DB();
        $statement = $con->prepare("UPDATE Coupon SET Value = ? , Active = 1 WHERE CouponID = ?");
        $statement->bind_param("ii", $couponRestValue, $couponID);
        $result = $statement->execute();

        if ($result) {
            $con->close();
            return true;
        } else {
            $con->close();
            return false;
        }
    }

    function getUserID($username) {
        $con = $this->connect2DB();
        $query = "SELECT * FROM User WHERE Username =  '" . $username . "'";
        $result = $con->query($query);
        if ($result) {
            $line = $result->fetch_object();
            $userID = $line->UserID;

            $con->close();
            return $userID;
        }
        $con->close();
        return false;
    }

    function inserRating($rating) {
        $con = $this->connect2DB();
        $statement = $con->prepare("INSERT INTO `rating` (`ProductID`, `UserID`, `Rating`) VALUES (?, ?, ?);");

        foreach ($rating as $element) {
            $statement->bind_param("iii", $element->getProductID(), $element->getUserID(), $element->getRating());
            $result = $statement->execute();
            if (!$result) {
                $con2 = $this->connect2DB();
                $statement2 = $con2->prepare("UPDATE `rating` SET `Rating` = ? WHERE `rating`.`ProductID` = ? AND `rating`.`UserID` = ?;");
                $statement2->bind_param("iii", $element->getRating(), $element->getProductID(), $element->getUserID());
                $result2 = $statement2->execute();
                consolePrint("-rating updated-");
                $con2->close();
            } else {
                consolePrint("-rating inserted-");
            }
        }
        $con->close();
    }

    function getAverageRating($productID) {
        $con = $this->connect2DB();
        $query = "SELECT ProductID, AVG(Rating) AS Mean FROM Rating WHERE ProductID = " . $productID . " GROUP BY ProductID";
        $result = $con->query($query);
        if ($result) {
            $line = $result->fetch_object();
            if(isset($line->Mean)){
                $mean = $line->Mean;
            }
            else {
                $mean = 0;
            }

            $con->close();
            return $mean;
        }
        $con->close();
        return false;
    }

    //-----------------------statements check line-----------------------------
//        function getSearchedProducts($search) {
//        $this->connect2DB();
//        $query = "SELECT * FROM Product WHERE Name LIKE '%" . $search . "%'";
//        $ergebnis = $this->connection->query($query);
//        if ($ergebnis) {
//            while ($zeile = $ergebnis->fetch_object()) {
//                echo '<tr>';
//                echo '<td>' . $zeile->ProductID . '</td>';
//                echo '<td>' . $zeile->Name . '</td>';
//                echo '<td>' . $zeile->Description . '</td>';
//                echo '<td>' . $zeile->Price . '</td>';
//                echo '</tr>';
//            }
//            $this->connection->close();
//            return true;
//        } else {
//            $this->connection->close();
//            return false;
//        }
//    }


    function getProductName($productID) {
        $this->connect2DB();
        $query = "SELECT Name FROM Product WHERE ProductID = $productID";
        $ergebnis = $this->connection->query($query);
        if ($ergebnis) {
            $zeile = $ergebnis->fetch_object();
            $this->connection->close();
            consolePrint("in der db: " . $zeile->Name);
            return $zeile->Name;
        }
        echo '<script>alert("fehler in der getProductName");</script>';
        $this->connection->close();
        return false;
    }

    function getProductPrice($productID) {
        $this->connect2DB();
        $query = "SELECT Price FROM Product WHERE ProductID = $productID";
        $ergebnis = $this->connection->query($query);
        if ($ergebnis) {
            $zeile = $ergebnis->fetch_object();
            $this->connection->close();
            return $zeile->Price;
        }
        echo '<script>alert("fehler in der getProductPrice");</script>';
        $this->connection->close();
        return false;
    }

    function insertCustomer($userID, $anrede, $vorname, $nachname, $adresse, $plz, $ort, $email) {
        $this->connect2DB();
        $query = "INSERT INTO Customer VALUES(NULL,'" . $userID . "','" . $anrede . "','" . $vorname . "','" . $nachname . "','" . $adresse . "','" . $plz . "','" . $ort . "','" . $email . "',NULL)"; //doppelt verschachtelte "','" nur wegen dem @ in der email adresse
        $ergebnis = $this->connection->query($query);
        $this->connection->close();
        if ($ergebnis) {
            return true;
        } else {
            return false;
        }
    }

    function insertUser($benutzername, $passwort) {
        $this->connect2DB();

        $query = "INSERT INTO user VALUES(NULL,2,'" . $benutzername . "','" . $passwort . "',1)";
        //$query = 'INSERT INTO user VALUES(NULL,2,"test","test")';
        $ergebnis = $this->connection->query($query);
        if ($ergebnis) {
            $last_id = $this->connection->insert_id; //speichert die durch AUTOINCREMENT festgelegte ID ab bevor die verbindung geschlossen wird
            $this->connection->close();
            return $last_id;
        }
        $this->connection->close();
        return false;
    }

    function insertProduct($categoryID, $name, $description, $price) {
        $this->connect2DB();
        $query = "INSERT INTO product VALUES(NULL,'" . $categoryID . "','" . $name . "','" . $price . "','" . $description . "')";
        $ergebnis = $this->connection->query($query);
        if ($ergebnis) {
            $last_id = $this->connection->insert_id;
            $this->connection->close();
            return $last_id;
        } else {

            $this->connection->close();
            return false;
        }
    }

    function insertOrder($orderedProducts, $customerID, $couponID) {
        $this->connect2DB();
        $date = new DateTime();
        $date = $date->format('Y-m-d H:i:s');
        //abit of a different querry than the other inside statements cos we had trouble with this one until we realized that the problem was that we
        //named the table "order", yet order is a mysql reserved word. after renaming the table this problem was solved
        if ($couponID == null) {
            $query = "INSERT INTO PurchaseOrder (CustomerID, CouponID, Date) VALUES('" . $customerID . "',NULL,'" . $date . "')"; //andere querry da selbst wenn $couponID == null der wert wird nicht richtig in die datenbank geschrieben
        } else {
            $query = "INSERT INTO PurchaseOrder (CustomerID, CouponID, Date) VALUES('" . $customerID . "','" . $couponID . "','" . $date . "')";
        }


        $ergebnis = $this->connection->query($query);
        if ($ergebnis) {
            $last_id = $this->connection->insert_id;

            //and here enter all the single products in the m:n entity ORDER_HAS_PRODUCTS
            //1 order can have many products and 1 product can be in many orders
            //$orderedProducts is a parameter which contains an object array of OrderedProducts
            foreach ($orderedProducts as $product) {
                $query = "INSERT INTO Order_Has_Products (OrderID, ProductID, Amount) VALUES (" . $last_id . "," . $product->getProductID() . "," . $product->getAmount() . ")";
                //alertPrint($query); //selber geschriebene hilfsfunktion die ein javascript alert fenster öffnet um zu testzwecken daten anzuschauen
                $ergebnis = $this->connection->query($query);
                if (!$ergebnis) {
                    alertPrint("ERROR while inserting into Order_Has_Products");
                    return false;
                }
                if ($couponID) {
                    $query = "UPDATE Coupon SET Active = 0 WHERE CouponID= " . $couponID;
                    $ergebnis = $this->connection->query($query);
                    if (!$ergebnis) {
                        alertPrint("ERROR while setting the coupon to inactive"); //in real sollte man diese meldung nicht dem kunden zeigen, da der kunde somit schliessen könnte, dass sein gutschein noch immer funktioniert. solche error msgs würde ich in einem größeren projekt in eine eigene error log tabelle reinschreiben
                        return false;
                    }
                }
            }

            $this->connection->close();
            return $last_id;
        } else {
            //echo '<script>alert("Fehler in der insertOrder-> ' . $this->connection->error . '");</script>';
            $this->connection->close();
            return false;
        }



//        $query = "INSERT INTO product VALUES(NULL,'" . $categoryID . "','" . $name . "','" . $price . "','" . $description . "')";
//        $ergebnis = $this->connection->query($query);
//        if ($ergebnis) {
//            $last_id = $this->connection->insert_id;
//            $this->connection->close();
//            return $last_id;
//        } else {
//            $this->connection->close();
//            return false;
//        }
    }

    function updatePayment($customerID, $payment) {
        $this->connect2DB();
        $query = "UPDATE Customer SET Zahlungsinfo = '" . $payment . "' WHERE CustomerID= " . $customerID;
        $ergebnis = $this->connection->query($query);
        return ($ergebnis) ? true : false;
    }

    function getCouponID($code) {
        $this->connect2DB();
        $query = "SELECT * FROM Coupon WHERE Code='" . $code . "'";
        $ergebnis = $this->connection->query($query);
        if ($ergebnis) {
            $zeile = $ergebnis->fetch_object();
            $CouponID = $zeile->CouponID;
            $this->connection->close();

            return $CouponID;
        }
        alertPrint("ich bin hier");
        return false;
    }

    function getOrderCount($customerID) {
        $this->connect2DB();
        $query = "SELECT COUNT(*) AS OrderCount FROM PurchaseOrder WHERE CustomerID = " . $customerID;
        $ergebnis = $this->connection->query($query);
        if ($ergebnis) {
            $zeile = $ergebnis->fetch_object();
            $orderCount = $zeile->OrderCount;
            $this->connection->close();
            return $orderCount;
        }
        $this->connection->close();
        return 0;
    }

    function deleteOrder($customerID, $orderID) {
        $this->connect2DB();
        $query = "DELETE FROM order_has_products WHERE OrderID = " . $orderID;
        $ergebnis = $this->connection->query($query);
        if ($ergebnis) {
            $query = "DELETE FROM purchaseorder WHERE OrderID = " . $orderID;
            $ergebnis = $this->connection->query($query);
            $this->connection->close();
            return true;
        }
        $this->connection->close();
        return false;
    }

    function getOrderedProducts($orderID) {
        $orderedProducts = array();

        $this->connect2DB();
        $query = "SELECT * FROM Order_Has_Products join Product using (ProductID) WHERE OrderID = " . $orderID;
        $ergebnis = $this->connection->query($query);
        if ($ergebnis) {
            while ($zeile = $ergebnis->fetch_object()) {
                $orderedProducts[] = new OrderedProduct($zeile->ProductID, $zeile->Name, $zeile->Price, $zeile->Amount);
            }
            $this->connection->close();
            return $orderedProducts;
        }
        $this->connection->close();
        return false;
    }

    function checkUser($username, $password) {
        $rights = 0;
        $this->connect2DB();
        $query = "SELECT usergroupID, username, password, active FROM user WHERE username='" . $username . "'";
        $ergebnis = $this->connection->query($query);
        if ($ergebnis) {
            $zeile = $ergebnis->fetch_object();
            if ($zeile->password == $password) {
                $rights = $zeile->usergroupID; // 1 wenn er admin ist 2 wenn er normaler user ist
                if ($zeile->active == 0) { // dont let the user in when he is set inactive
                    $rights = -1;
                }
            } else {
                //echo 'wrong pw!';
                $rights = 0;
                //$rights=99; //wenn falsches pw
            }
        }
        $this->connection->close();
        return $rights;
    }

    function getAllCustomers() {
        $this->connect2DB();
        $query = "SELECT * FROM customer JOIN user using (UserID)";
        $ergebnis = $this->connection->query($query);
        if ($ergebnis) {
            while ($zeile = $ergebnis->fetch_object()) {
                echo '<tr>';
                echo '<td>' . $zeile->Anrede . '</td>';
                echo '<td>' . $zeile->Vorname . '</td>';
                echo '<td>' . $zeile->Nachname . '</td>';
                echo '<td>' . $zeile->Adresse . '</td>';
                echo '<td>' . $zeile->PLZ . '</td>';
                echo '<td>' . $zeile->Ort . '</td>';
                echo '<td>' . $zeile->Email . '</td>';
                echo '<td>' . $zeile->Zahlungsinfo . '</td>';
                echo '<td>' . $zeile->Username . '</td>';
                if ($zeile->Active) {
                    echo '<td><span class="glyphicon glyphicon-ok" aria-hidden="true" title="Active"></span></td>';
                } else {
                    echo '<td><span class="glyphicon glyphicon-remove" aria-hidden="true" title="Inactive"></span></td>';
                }
                echo '<td><a href="customer_edit.php?customerID=' . $zeile->CustomerID . '">edit</a></td>';
                echo '<td><a href="show_order.php?customerID=' . $zeile->CustomerID . '">show order</a></td>';

                echo '</tr>';
            }
        }
    }

    function editCustomer($customerID) {
        $this->connect2DB();
        $query = "SELECT * FROM customer JOIN user using (UserID) WHERE CustomerID=" . $customerID;
        $ergebnis = $this->connection->query($query);
        if ($ergebnis) {
            while ($zeile = $ergebnis->fetch_object()) {
                echo '<tr>';
                echo '<td><input class="form-control" type="text" id="editAnrede" name="Anrede" value="' . $zeile->Anrede . '" required></td>';
                echo '<td><input class="form-control" type="text" id="editVorname" name="Vorname" value="' . $zeile->Vorname . '" required></td>';
                echo '<td><input class="form-control" type="text" id="editNachname" name="Nachname" value="' . $zeile->Nachname . '" required></td>';
                echo '<td><input class="form-control" type="text" id="editAdresse" name="Adresse" value="' . $zeile->Adresse . '" required></td>';
                echo '<td><input class="form-control" type="text" id="editPLZ" name="PLZ" value="' . $zeile->PLZ . '" required></td>';
                echo '<td><input class="form-control" type="text" id="editOrt" name="Ort" value="' . $zeile->Ort . '" required></td>';
                echo '<td><input class="form-control" type="text" id="editEmail" name="Email" value="' . $zeile->Email . '" required></td>';
                echo '<td><input class="form-control" type="text" id="editZahlungsinfo" name="Zahlungsinfo" value="' . $zeile->Zahlungsinfo . '"></td>';

                echo '<td>' . $zeile->Username . '</td>';
                if ($zeile->Active) {
                    echo '<td><input class="form-control" type="checkbox" id="editAktiv" name="Aktiv" value="1" checked></td>';
                } else {
                    echo '<td><input class="form-control" type="checkbox" id="editAktiv" name="Aktiv" value="0"></td>';
                }

                echo '</tr>';
            }
        }
    }

    function alterCustomer($customerID, $anrede, $vorname, $nachname, $adresse, $plz, $ort, $email, $zahlungsinfo, $aktiv) {
        $this->connect2DB();
        $query = "UPDATE Customer SET anrede='" . $anrede . "', vorname='" . $vorname . "', nachname='" . $nachname . "', adresse='" . $adresse . "', plz='" . $plz . "', ort='" . $ort . "', email='" . $email . "', zahlungsinfo ='" . $zahlungsinfo . "' WHERE CustomerID='" . $customerID . "';"; //doppelt verschachtelte "','" nur wegen dem @ in der email adresse

        $ergebnis = $this->connection->query($query);
        //$this->connection->close();

        if ($ergebnis) {
            $query = "SELECT * FROM Customer join User using(UserID) WHERE CustomerID='" . $customerID . "';";
            $ergebnis = $this->connection->query($query);
            $zeile = $ergebnis->fetch_object();
            $UserID = $zeile->UserID;
            //$this->connection->close();

            $query = "UPDATE user SET active='" . $aktiv . "' WHERE UserID='" . $UserID . "';";
            $ergebnis = $this->connection->query($query);
            $this->connection->close();

            return true;
        } else {
            return false;
        }
    }

    function getAllProducts() {
        $this->connect2DB();
        $query = "Select * from Product JOIN Category using(CategoryID)";
        $ergebnis = $this->connection->query($query);
        if ($ergebnis) {
            while ($zeile = $ergebnis->fetch_object()) {
                echo '<tr>';
                echo '<td><img src="../pictures/CAT_' . $zeile->CategoryID . '/' . $zeile->ProductID . '.png" alt="Product Image" class="product_icon"></td>';
                echo '<td>' . $zeile->ProductID . '</td>';
                echo '<td>' . $zeile->CategoryName . '</td>';
                echo '<td>' . $zeile->CategoryID . '</td>';
                echo '<td>' . $zeile->Name . '</td>';
                echo '<td>' . $zeile->Description . '</td>';
                echo '<td>' . $zeile->Price . '</td>';
                echo '<td><a href="edit_product.php?productID=' . $zeile->ProductID . '">edit</a></td>';
                echo '<td><a href="?productID=' . $zeile->ProductID . '&categoryID=' . $zeile->CategoryID . '&delete=1">delete</a></td>';
                echo '</tr>';
            }
            $this->connection->close();
            return true;
        } else {
            $this->connection->close();
            return false;
        }
    }

    function decrementAmountInOrder($orderID, $productID) {
        $this->connect2DB();
        $query = "UPDATE order_has_products SET Amount = Amount - 1 WHERE OrderID = " . $orderID . " AND ProductID = " . $productID;
        $ergebnis = $this->connection->query($query);
        if ($ergebnis) {
            $this->connection->close();
            return true;
        }
        $this->connection->close();
        return false;
    }

    function deleteProductFromOrder($orderID, $productID) {
        $this->connect2DB();
        $query = "DELETE FROM order_has_products WHERE OrderID = " . $orderID . " AND ProductID = " . $productID;
        $ergebnis = $this->connection->query($query);
        if ($ergebnis) {
            $this->connection->close();
            return true;
        }
        $this->connection->close();
        return false;
    }

    function getOneCategory($productID) {
        $this->connect2DB();
        $query = "Select * from Product WHERE ProductID = " . $productID;
        $ergebnis = $this->connection->query($query);
        if ($ergebnis) {
            $zeile = $ergebnis->fetch_object();
            $categoryID = $zeile->CategoryID;
            $this->connection->close();
            return $categoryID;
        }
        $this->connection->close();
        return false;
    }

    function getAllCoupons() {
        $this->connect2DB();
        $query = "Select * from Coupon";
        $ergebnis = $this->connection->query($query);
        if ($ergebnis) {
            while ($zeile = $ergebnis->fetch_object()) {
                echo '<tr>';

                echo '<td>' . $zeile->CouponID . '</td>';
                echo '<td>' . $zeile->Code . '</td>';
                echo '<td>€ ' . $zeile->Value . ',-</td>';
                echo '<td>' . $zeile->Active . '</td>';
                echo '<td>' . $zeile->ExpireDate . '</td>';
                echo '</tr>';
            }
            $this->connection->close();
            return true;
        } else {
            $this->connection->close();
            return false;
        }
    }

    function getCategory() {
        //$temp = array();
        $this->connect2DB();
        $query = "Select * from Category";
        $ergebnis = $this->connection->query($query);
        if ($ergebnis) {
            while ($zeile = $ergebnis->fetch_object()) {
                echo "<option value='" . $zeile->CategoryID . "'>" . $zeile->CategoryName . "</option>";

//                vieleicht mit array_push???????
//                $temp = $zeile->CategoryName;
            }
            $this->connection->close();
//            return $temp;
            return true;
        } else {
            echo 'FAILURE';
            $this->connection->close();
            return false;
        }
    }

    function getCategoryForCustomerView($cat) {
        $this->connect2DB();
        $query = "Select * from Category";
        $ergebnis = $this->connection->query($query);
        if ($ergebnis) {
            while ($zeile = $ergebnis->fetch_object()) {
                if ($cat == $zeile->CategoryID) {
                    echo "<option value='?category=" . $zeile->CategoryID . "' selected>" . $zeile->CategoryName . "</option>";
                } else {
                    echo "<option value='?category=" . $zeile->CategoryID . "'>" . $zeile->CategoryName . "</option>";
                }
            }
            $this->connection->close();
//            return $temp;
            return true;
        } else {
            echo 'FAILURE';
            $this->connection->close();
            return false;
        }
    }

    //auch ausgabe muss hier erstellt werden, da diese der ajax call braucht!
    function showCartProducts($prodID) {
        $this->connect2DB();
        $query = "Select * from Product JOIN Category using(CategoryID) WHERE ProductID =" . $prodID;
        $ergebnis = $this->connection->query($query);
        if ($ergebnis) {
            while ($zeile = $ergebnis->fetch_object()) {
                echo '<div>';
                echo '<img src="../pictures/CAT_' . $zeile->CategoryID . '/' . $zeile->ProductID . '.png" class="cart_pic img-rounded">';
                echo '<p class="cart_txt_name"><strong>' . $zeile->Name . '</strong></p>';
                echo '<p class="cart_txt_count" id="cart_item_count_' . $zeile->ProductID . '"><strong>Count:</strong> ' . array_count_values($_SESSION['cart'])[$zeile->ProductID] . '</p>';
                echo '<p class="cart_txt_price"><strong>€</strong>' . $zeile->Price . '</p>';
                echo '<form style="float:left;" method="post" action="?ProductID=' . $zeile->ProductID . '&delete=1">';
                echo '<button value="submit" type="submit" class="btn btn-primary" style="padding-top:0;padding-bottom:0;">-</button>';
                echo '</form>';
                echo '<form style="float:left; clear:right;" method="post" action="?ProductID=' . $zeile->ProductID . '&add=1">';
                echo '<button value="submit" type="submit" class="btn btn-primary" style="padding-top:0;padding-bottom:0;">+</button>';
                echo '</form>';
                //echo '<a class="cart_link"href="#">remove</a>';
                $this->totalPrice += $zeile->Price;
                echo '</div><br><br>';
            }
        }
    }

    function showTotalPrice() {
        echo '<p class="total_price" id="totalPrice"><strong>Total Price: €' . $_SESSION['totalPrice'] . '</strong></p>';
        //$_SESSION['totalPrice'] = $this->totalPrice;
    }

    function showAllProducts($cat) {
        $cnt = 0;
        $cnt_max = 3;
        $con = $this->connect2DB();

        $query = "Select * from Product JOIN Category using(CategoryID) WHERE CategoryID =" . $cat;
        $ergebnis = $this->connection->query($query);


        if ($ergebnis) {
            while ($zeile = $ergebnis->fetch_object()) {

                if ($cnt == 0) {
                    echo '<div class="row">';
                }


                echo '<div class="col-md-3">';
                echo '<div class="product">';
                echo '<p class="product_name img-rounded"><strong>' . $zeile->Name . '</strong></p>';
                echo '<div class="product_pic_div img-rounded"><img src="../pictures/CAT_' . $zeile->CategoryID . '/' . $zeile->ProductID . '.png"  class="product_pic" id="drag_' . $zeile->ProductID . '"></div>';
                echo '<p class="product_description"><strong>Description: </strong>' . $zeile->Description . '</p>';
                echo '<div class="half_wrapper">';
                echo '<p class="half"><strong>Price: </strong>€' . $zeile->Price . '</p>';
                echo '<p class="half half_rating"><strong>Rating:</strong></p><div class="rating"><span>☆</span><span>☆</span><span>☆</span><span>☆</span><span>☆</span></div>';
                echo '</div>';
                echo '<button type="button" class="btn btn-primary cartButton" id="' . $zeile->ProductID . '" value="' . $zeile->Price . '">add to cart</button>';
                echo '</div>';
                echo '</div>';
                if ($cnt == $cnt_max) {
                    echo '</div><br><hr><br><br>';
                    $cnt = 0;
                } else {
                    $cnt++;
                }
            }
            $this->connection->close();
            return true;
        } else {
            $this->connection->close();
            return false;
        }
    }

    function checkCoupon($coupon) {
        $this->connect2DB();
        $query = "Select * FROM Coupon";
        $ergebnis = $this->connection->query($query);
        if ($ergebnis) {
            while ($zeile = $ergebnis->fetch_object()) {
                if ($zeile->Code == $coupon) {
                    if ($zeile->Active) {
                        $tmpDate = new DateTime();
                        $tmpDate = $tmpDate->format('Y-m-d H:i:s');
                        if ($zeile->ExpireDate > $tmpDate) {
                            return $zeile->Value;
                        }
                        consolePrint("Fehler expire Date: " . $zeile->ExpireDate . " AND " . $tmpDate);
                        return -3;
                    } else {
                        consolePrint("Fehler inaktiv");
                        return -1;
                    }
                }
            }
            consolePrint("Falscher code");
            return -2;
        }
        return false;
    }

    function insertCoupon($coupon) {
        $code = $coupon->getCode();
        $value = $coupon->getValue();
        $active = $coupon->getActive();
        $expireDate = $coupon->getExpireDate();
        $this->connect2DB();
        //consolePrint($coupon->getCode());

        $query = "INSERT INTO Coupon VALUES(NULL,'" . $code . "','" . $value . "','" . $active . "','" . $expireDate . "')";
        //$query = "INSERT INTO Coupon VALUES(NULL,'" . $code. "','" . $value. "','" . $active . "', DATE_ADD('".$expireDate. "', INTERVAL 1 YEAR)";                                     // '" . $categoryID . "','" . $name . "','" . $price . "','" . $description . "')";
        $ergebnis = $this->connection->query($query);
        if ($ergebnis) {
            $last_id = $this->connection->insert_id;
            consolePrint($this->connection->error);
            consolePrint($query);
            $this->connection->close();
            consolePrint("success");
            return $last_id;
        } else {
            //consolePrint($this->connection->error);
            consolePrint($query);
            $this->connection->close();
            consolePrint("failure: " . $query);
            return false;
        }
    }

}

//        function deleteProduct($produktId){
//            $this->connect2DB();
//            $query = "Delete from produkte where id = $produktId";
//            $ergebnis = $this->connection->query($query);
//        }
*/
?>
