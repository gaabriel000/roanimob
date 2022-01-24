/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
package controller;

import java.net.URL;
import java.util.ResourceBundle;
import javafx.event.ActionEvent;
import javafx.fxml.FXML;
import javafx.fxml.Initializable;
import javafx.scene.paint.Color;
import javafx.scene.text.Font;
import model.MainContainer;
import model.Roanimob;

/**
 *
 * @author Gabriel
 */
public class TemplateController implements Initializable, ScreenInterface {

    MainContainer parentController;

    @FXML
    private Font x3;

    @FXML
    private Color x4;

    @Override
    public void initialize(URL url, ResourceBundle rb) {
        // TODO
    }

    @Override
    public void setScreenParent(MainContainer mainController) {
        parentController = mainController;
    }

    public void cadastroLocadorImovel(ActionEvent event) {
        parentController.setScreen(Roanimob.locadorImovelID);
    }
}
