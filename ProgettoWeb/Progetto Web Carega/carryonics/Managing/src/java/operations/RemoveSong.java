/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
package operations;

import java.io.IOException;
import java.io.PrintWriter;
import java.sql.Connection;
import java.sql.DriverManager;
import java.sql.PreparedStatement;
import java.sql.SQLException;
import java.util.logging.Level;
import java.util.logging.Logger;
import javax.servlet.ServletException;
import javax.servlet.http.HttpServlet;
import javax.servlet.http.HttpServletRequest;
import javax.servlet.http.HttpServletResponse;

/**
 *
 * @author Marco-PC
 */
public class RemoveSong extends HttpServlet {

    
     private Connection connection;
    private PreparedStatement control;
    private String sql;
    
    @Override
    public void init()
    {
        try {
            Class.forName("com.mysql.jdbc.Driver");
            connection=DriverManager.getConnection("jdbc:mysql://localhost:3306/carryonics","root","");
            sql="select id,name,amount from products where name=?";
            control=connection.prepareStatement(sql);
           connection.setAutoCommit(false);
        } catch (ClassNotFoundException ex) {
            Logger.getLogger(Insert.class.getName()).log(Level.SEVERE, null, ex);
        } catch (SQLException ex) {
            Logger.getLogger(Insert.class.getName()).log(Level.SEVERE, null, ex);
        }
    }
    /**
     * Processes requests for both HTTP <code>GET</code> and <code>POST</code>
     * methods.
     *
     * @param request servlet request
     * @param response servlet response
     * @throws ServletException if a servlet-specific error occurs
     * @throws IOException if an I/O error occurs
     */
    protected void processRequest(HttpServletRequest request, HttpServletResponse response)
            throws ServletException, IOException {
        response.setContentType("text/html;charset=UTF-8");
        PrintWriter out = response.getWriter();
        try {
            /* TODO output your page here. You may use following sample code. */
            String value=request.getParameter("remove");
            String[] parts=value.split("-");
            long song=Long.parseLong(parts[0]);
            int cd=Integer.parseInt(parts[1]);
            int vinil=Integer.parseInt(parts[2]);
            boolean checked=false;
            for(int i=0;i<cd;i++)
            {
                String check=request.getParameter("cd"+i);
                if(check!=null)
                {
                    checked=true;
                    long album=Long.parseLong(check);
                    String deleteSql="delete from cd_song where album=? and song=?";
                    PreparedStatement delete=connection.prepareStatement(deleteSql);
                    delete.setLong(1,album);
                    delete.setLong(2,song);
                    delete.executeUpdate();
                }
            }
            for(int i=0;i<vinil;i++)
            {
                String check=request.getParameter("vinil"+i);
                if(check!=null)
                {
                    checked=true;
                    long album=Long.parseLong(check);
                    String deleteSql="delete from vinil_song where album=? and song=?";
                    PreparedStatement delete=connection.prepareStatement(deleteSql);
                    delete.setLong(1,album);
                    delete.setLong(2,song);
                    delete.executeUpdate();
                }
            }
            if(checked)
            {
                connection.commit();
                out.println("Song deleted from albums!");
            }
            else out.println("Please select almost an album!");
        } catch (SQLException ex) {
            try {
                connection.rollback();
            } catch (SQLException ex1) {
                Logger.getLogger(RemoveSong.class.getName()).log(Level.SEVERE, null, ex1);
            }
             Logger.getLogger(RemoveSong.class.getName()).log(Level.SEVERE, null, ex);
         } finally {
            out.close();
        }
    }

    // <editor-fold defaultstate="collapsed" desc="HttpServlet methods. Click on the + sign on the left to edit the code.">
    /**
     * Handles the HTTP <code>GET</code> method.
     *
     * @param request servlet request
     * @param response servlet response
     * @throws ServletException if a servlet-specific error occurs
     * @throws IOException if an I/O error occurs
     */
    @Override
    protected void doGet(HttpServletRequest request, HttpServletResponse response)
            throws ServletException, IOException {
        processRequest(request, response);
    }

    /**
     * Handles the HTTP <code>POST</code> method.
     *
     * @param request servlet request
     * @param response servlet response
     * @throws ServletException if a servlet-specific error occurs
     * @throws IOException if an I/O error occurs
     */
    @Override
    protected void doPost(HttpServletRequest request, HttpServletResponse response)
            throws ServletException, IOException {
        processRequest(request, response);
    }

    /**
     * Returns a short description of the servlet.
     *
     * @return a String containing servlet description
     */
    @Override
    public String getServletInfo() {
        return "Short description";
    }// </editor-fold>

}
