/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
package operations;

import java.io.File;
import java.io.FileInputStream;
import java.io.FileNotFoundException;
import java.io.FileOutputStream;
import java.io.IOException;
import java.io.PrintWriter;
import java.sql.Connection;
import java.sql.Date;
import java.sql.DriverManager;
import java.sql.PreparedStatement;
import java.sql.ResultSet;
import java.sql.SQLException;
import java.text.ParseException;
import java.text.SimpleDateFormat;
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
public class UpDelProduct extends HttpServlet {

    /**
     * Processes requests for both HTTP <code>GET</code> and <code>POST</code>
     * methods.
     *
     * @param request servlet request
     * @param response servlet response
     * @throws ServletException if a servlet-specific error occurs
     * @throws IOException if an I/O error occurs
     */
    private Connection connection;
    
    @Override
    public void init()
    {
        try {
            Class.forName("com.mysql.jdbc.Driver");
            connection=DriverManager.getConnection("jdbc:mysql://localhost:3306/carryonics","root","");
           connection.setAutoCommit(false);
           connection.setTransactionIsolation(Connection.TRANSACTION_SERIALIZABLE);
        } catch (ClassNotFoundException ex) {
            Logger.getLogger(Insert.class.getName()).log(Level.SEVERE, null, ex);
        } catch (SQLException ex) {
            Logger.getLogger(UpDelProduct.class.getName()).log(Level.SEVERE, null, ex);
        }
    }
    
    
    protected void processRequest(HttpServletRequest request, HttpServletResponse response)
            throws ServletException, IOException {
        response.setContentType("text/html;charset=UTF-8");
        PrintWriter out = response.getWriter();
       try
       {
           String name=request.getParameter("name");
           String controlSql="select id,category from products where name=?";
           PreparedStatement control=connection.prepareStatement(controlSql);
           control.setString(1, name);
           ResultSet result=control.executeQuery();
           if(!result.first())
           {
               out.println("This product is not in the DB, please go back and use another name!");
               
           }
           else
           {
               String button=request.getParameter("updel");
               //out.println(button);
               if(button.equals("delete"))
                 {
                     String cat=result.getString("category");
                     long id=result.getLong("id");
                     String deleteProductSql="delete from products where id=?";
                     String deleteCatSql="delete from "+cat+" where product=?";
                     //out.println("ok");
                     PreparedStatement deleteCat=connection.prepareStatement(deleteCatSql);
                     //deleteCat.setString(1,cat);
                     deleteCat.setLong(1, id);
                     //out.println("ook");
                     //out.println(deleteCat.toString());
                     deleteCat.executeUpdate();
                     PreparedStatement deleteProduct=connection.prepareStatement(deleteProductSql);
                     deleteProduct.setLong(1,id);
                     int res=deleteProduct.executeUpdate();
                     //out.println("oook");
                     if(res==1)
                     {
                         out.println(name+" deleted from DB!");
                         connection.commit();
                     }
                     else
                     {
                         out.println("Error!");
                         connection.rollback();
                     }
                }
                else if(button.equals("update"))
                {
                    long id=result.getLong("id");
                    String firstSql=getFirstQuery(request,id);
                    out.println(firstSql);
                    String cat=result.getString("category");
                    String secondSql=getSecondQuery(request,id,cat);
                    out.println(secondSql);
                    if(!firstSql.equals(""))
                    {
                        
                        PreparedStatement first=connection.prepareStatement(firstSql);
                        out.println("first");
                        int res=first.executeUpdate();
                        if(res==1)
                        {
                            if(secondSql.equals("")) connection.commit();
                        }
                        else
                        {
                            out.println("Error!");
                            connection.rollback();   
                        }
                    }
                    
                    if(!secondSql.equals(""))
                    {
                     
                        out.println("second");
                        PreparedStatement second=connection.prepareStatement(secondSql);
                        int res=second.executeUpdate();
                        if(res==1)
                        {
                            connection.commit();
                        }    
                        else
                        {
                            out.println("Error!");
                            if(!firstSql.equals("")) connection.rollback();
                            connection.rollback();
                            return;
                        }
                    }
                    if((firstSql+secondSql).equals("")) out.println("Please compile the form with the name and the skill you want to change!");
                    else out.println(name+" updated");
                }
            }
       }  
            
       catch(SQLException e)
       {
           out.println(e.getMessage());
       } catch (ParseException ex) {
            Logger.getLogger(UpDelProduct.class.getName()).log(Level.SEVERE, null, ex);
        }
    }

    private String getFirstQuery(HttpServletRequest request,long id) throws ParseException, IOException
    {
        String sql="";
        String desc=request.getParameter("desc");
        if(!desc.trim().equals("")) sql+="description='"+desc+"', ";
        String amount=request.getParameter("amount");
        if(!amount.equals("")) sql+="amount="+amount+", ";
        String genre=request.getParameter("genre");
        if(!genre.equals("")) sql+="genre='"+genre+"', ";
        String date=request.getParameter("release");
        if(!date.equals(""))
        {
            long millis=new SimpleDateFormat("yyyy-MM-dd").parse(date).getTime();
            Date release=new Date(millis);
            
            sql+="release_date='"+release.toString()+"', ";
        }
        String photo=request.getParameter("image");
        if(!photo.equals(""))
        {
            photo=storeImage(photo);
            sql+="photo='"+photo+"', ";
        }
        String price=request.getParameter("price");
        if(price.equals(""))
        {
            float cost=Float.parseFloat(price);
            sql+="price="+cost+", ";
        }
        if(sql.equals("")) return sql;
        else return String.format("update products set %s where id=%d",sql.substring(0,sql.length()-2),id);
    }
    
      private String getSecondQuery(HttpServletRequest request,long id,String cat)
    {
        String sql="";
        if(cat.equals("books"))
        {
            String author=request.getParameter("bookauthor");
            if(!author.equals("")) sql+="author='"+author+"', ";
            String publisher=request.getParameter("bookpublisher");
            if(!publisher.equals("")) sql+="publisher='"+publisher+"', ";
            String isbn=request.getParameter("isbn");
            if(!isbn.equals("")) sql+="isbn='"+isbn+"', ";
            String pages=request.getParameter("pages");
            if(!pages.equals("")) sql+="pages="+pages+", ";
        }
        else if(cat.equals("cds") || cat.equals("vinils"))
        {
            String author=request.getParameter("musicauthor");
            if(!author.equals("")) sql+="author="+author+", ";
        }
        else if(cat.equals("films"))
        {
            String director=request.getParameter("director");
            if(!director.equals("")) sql+="director="+director+", ";
            String producer=request.getParameter("producer");
            if(!producer.equals("")) sql+="producer="+producer+", ";
        }
        else if(cat.equals("games"))
        {
            String developer=request.getParameter("developer");
            if(!developer.equals("")) sql+="developer="+developer+", ";
            String publisher=request.getParameter("gamepublisher");
            if(!publisher.equals("")) sql+="publisher="+publisher+", ";
            String console=request.getParameter("console");
            if(!console.equals("")) sql+="console="+console+", ";
            String pegi=request.getParameter("pegi");
            if(!pegi.equals("")) sql+="pegi="+pegi+", ";
            
        }
        if(sql.equals("")) return sql;
        else return String.format("update %s set %s where product=%d",cat,sql.substring(0,sql.length()-2),id);
    }
      
      private String storeImage(String imgName) throws FileNotFoundException, IOException
    {
        String path="D:\\\\Programmi\\\\xampp\\\\htdocs\\\\carryonics\\\\"+imgName;

        File image=new File("\\\\localhost\\condiv\\"+imgName);
        File stored=new File(path);
        FileInputStream input= new FileInputStream(image);
        FileOutputStream output= new FileOutputStream(stored);
        int stream=0;
        do
        {
            stream=input.read();
            output.write(stream);
        }
        while(stream!=-1);
        input.close();
        output.close();
        return imgName;

       //throw new UnsupportedOperationException("Not supported yet."); //To change body of generated methods, choose Tools | Templates.
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
